package main

import (
	"database/sql"
	"encoding/xml"
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
	XMLName  xml.Name  `xml:"response"`
	Products []Product `xml:"products"`
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

// Función para obtener todos los productos registrados
func getAllProducts(w http.ResponseWriter, r *http.Request) {
	// Obtener todos los productos de la base de datos
	db := dbConn()
	rows, err := db.Query("SELECT * FROM productos")
	if err != nil {
		panic(err.Error())
	}
	defer db.Close()

	// Crear una lista de productos
	var products []Product
	for rows.Next() {
		var product Product
		err := rows.Scan(&product.ID, &product.Nombre, &product.Descripcion, &product.Precio, &product.Stock, &product.Proveedor)
		if err != nil {
			panic(err.Error())
		}
		products = append(products, product)
	}

	// Crear la respuesta
	response := Response{Products: products}

	// Codificar la respuesta en XML y enviarla
	w.Header().Set("Content-Type", "application/xml")
	err = xml.NewEncoder(w).Encode(response)
	if err != nil {
		log.Printf("Error al codificar la respuesta XML: %v", err)
	}
}

func main() {
	// Configurar el servicio SOAP
	http.HandleFunc("/getAllProducts", getAllProducts)

	// Iniciar el servidor
	log.Println("Iniciando el servidor SOAP en http://localhost:8080...")
	log.Fatal(http.ListenAndServe(":8080", nil))
}
