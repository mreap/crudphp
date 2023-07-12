<?php
require_once 'Database.php';
require_once 'Producto.php';
/**
 * Componente model para el manejo de productos.
 *
 */
class ProductoModel
{
    /**
     * Obtiene todos los productos de la base de datos.
     * @return array
     */
    public function getProductos()
    {
        //obtenemos la informacion de la bdd:
        $pdo = Database::connect();
        $sql = "select * from producto order by nombre";
        $resultado = $pdo->query($sql);
        //transformamos los registros en objetos de tipo Producto:
        $listado = array();
        foreach ($resultado as $res) {
            $producto = new Producto();
            $producto->codigo=$res['codigo'];
            $producto->nombre=$res['nombre'];
            $producto->precio=$res['precio'];
            $producto->cantidad=$res['cantidad'];
            array_push($listado, $producto);
        }
        Database::disconnect();
        //retornamos el listado resultante:
        return $listado;
    }
    /**
     * Obtiene un producto especifico.
     * @param $codigo El codigo del producto a buscar.
     * @return \Producto
     */
    public function getProducto($codigo)
    {
        //Obtenemos la informacion del producto especifico:
        $pdo = Database::connect();
        //Utilizamos parametros para la consulta:
        $sql = "select * from producto where codigo=?";
        $consulta = $pdo->prepare($sql);
        //Ejecutamos y pasamos los parametros para la consulta:
        $consulta->execute(array($codigo));
        //Extraemos el registro especifico:
        $dato = $consulta->fetch(PDO::FETCH_ASSOC);
        //Transformamos el registro obtenido a objeto:
        $producto = new Producto();
        $producto->codigo=$dato['codigo'];
        $producto->nombre=$dato['nombre'];
        $producto->precio=$dato['precio'];
        $producto->cantidad=$dato['cantidad'];
        Database::disconnect();
        return $producto;
    }
    /**
     * Crea un nuevo producto en la base de datos.
     * @param $codigo
     * @param $nombre
     * @param $precio
     * @param $cantidad
     */
    public function crearProducto($nombre, $precio, $cantidad)
    {
        //Preparamos la conexion a la bdd:
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //Preparamos la sentencia con parametros:
        $sql = "insert into producto (nombre,precio,cantidad) values(?,?,?)";
        $consulta = $pdo->prepare($sql);
        //Ejecutamos y pasamos los parametros:
        $consulta->execute(array($nombre, $precio, $cantidad));
        Database::disconnect();
    }
    /**
     * Elimina un producto especifico de la bdd.
     * @param $codigo
     */
    public function eliminarProducto($codigo)
    {
        //Preparamos la conexion a la bdd:
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "delete from producto where codigo=?";
        $consulta = $pdo->prepare($sql);
        //Ejecutamos la sentencia incluyendo a los parametros:
        $consulta->execute(array($codigo));
        Database::disconnect();
    }
    /**
     * Actualiza un producto existente.
     * @param $codigo
     * @param $nombre
     * @param $precio
     * @param $cantidad
     */
    public function actualizarProducto($codigo, $nombre, $precio, $cantidad)
    {
        //Preparamos la conexión a la bdd:
        $pdo = Database::connect();
        $sql = "update producto set nombre=?,precio=?,cantidad=? where codigo=?";
        $consulta = $pdo->prepare($sql);
        //Ejecutamos la sentencia incluyendo a los parametros:
        $consulta->execute(array($nombre, $precio, $cantidad, $codigo));
        Database::disconnect();
    }
}
