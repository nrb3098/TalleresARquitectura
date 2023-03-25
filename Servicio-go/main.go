package main

import (
	"database/sql"
	"encoding/xml"
	"fmt"
	"io/ioutil"
	"log"
	"net/http"

	_ "github.com/go-sql-driver/mysql"
)

// Estructura de datos para el producto
type Product struct {
	XMLName     xml.Name `xml:"product"`
	ID          int      `xml:"id"`
	Nombre      string   `xml:"nombre"`
	Descripcion string   `xml:"descripcion"`
	Precio      float32  `xml:"precio"`
	Stock       int      `xml:"stock"`
	Proveedor   string   `xml:"proveedor"`
}

// Estructura de datos para la respuesta
type Response struct {
	XMLName xml.Name `xml:"response"`
	Message string   `xml:"message"`
}

// Conexión a la base de datos MySQL
func dbConn() (db *sql.DB) {
	dbDriver := "mysql"
	dbUser := "root"
	dbPass := "1234"
	dbName := "sys"
	db, err := sql.Open(dbDriver, dbUser+":"+dbPass+"@/"+dbName)
	if err != nil {
		panic(err.Error())
	}
	return db
}

// Función para registrar un producto
func registerProduct(w http.ResponseWriter, r *http.Request) {
	// Decodificar la solicitud XML en una estructura de datos de producto
	var product Product
	err := xml.NewDecoder(r.Body).Decode(&product)
	if err != nil {
		http.Error(w, err.Error(), http.StatusBadRequest)
		return
	}

	// Registrar el producto en la base de datos
	db := dbConn()
	insert, err := db.Prepare("INSERT INTO productos(id, nombre, descripcion, precio, stock, proveedor) VALUES(?,?,?,?,?,?)")
	if err != nil {
		panic(err.Error())
	}
	fmt.Println(product.Nombre)
	fmt.Println(product.Descripcion)
	insert.Exec(product.ID, product.Nombre, product.Descripcion, product.Precio, product.Stock, product.Proveedor)
	defer db.Close()

	// Crear la respuesta
	response := Response{Message: "El producto ha sido registrado exitosamente." + product.Nombre}

	// Codificar la respuesta en XML y enviarla
	w.Header().Set("Content-Type", "application/xml")
	err = xml.NewEncoder(w).Encode(response)
	if err != nil {
		log.Printf("Error al codificar la respuesta XML: %v", err)
	}
}

func main() {

	// Configurar el servicio SOAP
	http.HandleFunc("/registerProduct", registerProduct)

	// Iniciar el servidor
	log.Println("Iniciando el servidor SOAP en http://localhost:8081...")
	log.Fatal(http.ListenAndServe(":8081", nil))

	http.HandleFunc("/registerProduct?wsdl", func(w http.ResponseWriter, r *http.Request) {
		wsdlBytes, err := ioutil.ReadFile("registerProduct.wsdl")
		if err != nil {
			http.Error(w, err.Error(), http.StatusInternalServerError)
			return
		}
		w.Header().Set("Content-Type", "application/xml")
		w.Write(wsdlBytes)
	})
}
