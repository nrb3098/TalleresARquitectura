use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

class ProductController extends Controller
{
    public function registerProduct(Request $request)
        {
            dd($request->all());
            $id = $request->input('id');
            $nombre = $request->input('nombre');
            $descripcion = $request->input('descripcion');
            $precio = $request->input('precio');
            $stock = $request->input('stock');
            $proveedor = $request->input('proveedor');

            $xml_data = '<product>
                    <id>' . $id . '</id>
                    <nombre>' . $nombre . '</nombre>
                    <descripcion>' . $descripcion . '</descripcion>
                    <precio>' . $precio . '</precio>
                    <stock>' . $stock . '</stock>
                    <proveedor>' . $proveedor . '</proveedor>
                </product>';

            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_PORT => "8081",
                CURLOPT_URL => "http://localhost:8081/registerProduct",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => $xml_data,
                CURLOPT_HTTPHEADER => array(
                    "Content-Type: application/xml"
                ),
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
                echo "cURL Error #:" . $err;
            } else {
                echo $response;
            }
        }

}

