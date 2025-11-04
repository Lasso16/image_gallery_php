<?php class Imagen {
    /**
    *@var int
    */
    private $id;
    /**
    *@var string
    */
    private $nombre;
    /**
    *@var string
    */
    private $descripcion;
    /**
    *@var string
    */
    private $categoria;
    /**
    *@var int
    */
    private $numVisualizaciones;
    /**
    *@var int
    */
    private $numLikes;
    /**
    *@var int
    */
    private $numDownloads;

    const RUTA_IMAGENES_PORTFOLIO = '/public/images/index/portfolio/';
    const RUTA_IMAGENES_GALERIA = '/public/images/index/gallery/';
    const RUTA_IMAGENES_CLIENTES = '/public/images/clients/';
    const RUTA_IMAGENES_SUBIDAS = __DIR__ . "/../../public/images/galeria/";

    public function __construct($nombre,  $descripcion,  $categoria,  $numVisualizaciones= 0,  $numLikes= 0,  $numDownloads = 0) {
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->categoria = $categoria;
        $this->numVisualizaciones = $numVisualizaciones;
        $this->numLikes = $numLikes;
        $this->numDownloads = $numDownloads;
    }

    /**
     * Summary of getId
     * @return int
     */
    public function getId(): int {
        return $this->id;
    }

    /**
     * Summary of getNombre
     * @return string
     */
	public function getNombre(): string {
        return $this->nombre;
    }

    /**
     * Summary of getDescripcion
     * @return string
     */
	public function getDescripcion(): string{
        return $this->descripcion;
    }
    /**
     * Summary of getCategoria
     * @return string
     */
	public function getCategoria(): string {
        return $this->categoria;
    }
    /**
     * Summary of getNumVisualizaciones
     * @return int
     */
	public function getNumVisualizaciones(): int {
        return $this->numVisualizaciones;
    }
    /**
     * Summary of getNumLikes
     * @return int
     */
	public function getNumLikes(): int {
        return $this->numLikes;
    }
    /**
     * Summary of getNumDownloads
     * @return int
     */
	public function getNumDownloads(): int {
        return $this->numDownloads;
    }
    /**
     * Summary of setNombre
     * @param mixed $nombre
     * @return Imagen
     */
    public function setNombre( $nombre): Imagen {
        $this->nombre = $nombre;
        return $this;
    }
    /**
     * Summary of setDescripcion
     * @param mixed $descripcion
     * @return Imagen
     */
	public function setDescripcion( $descripcion): Imagen {
        $this->descripcion = $descripcion;
        return $this;
    }
    /**
     * Summary of setCategoria
     * @param mixed $categoria
     * @return Imagen
     */
	public function setCategoria( $categoria): Imagen {
        $this->categoria = $categoria;
        return $this;
    }
    /**
     * Summary of setNumVisualizaciones
     * @param mixed $numVisualizaciones
     * @return Imagen
     */
	public function setNumVisualizaciones( $numVisualizaciones): Imagen {
        $this->numVisualizaciones = $numVisualizaciones;
        return $this;
    }
    /**
     * Summary of setNumLikes
     * @param mixed $numLikes
     * @return Imagen
     */
	public function setNumLikes( $numLikes): Imagen {
        $this->numLikes = $numLikes;
        return $this;
    }
    /**
     * Summary of setNumDownloads
     * @param mixed $numDownloads
     * @return Imagen
     */
	public function setNumDownloads( $numDownloads): Imagen {
        $this->numDownloads = $numDownloads;
        return $this;
    }

    function __tostring() {
        return $this->descripcion;
    }
	

    function getUrlPortfolio() {
        return self::RUTA_IMAGENES_PORTFOLIO . $this->getNombre();
    }
	
    function getUrlGaleria() {
        return self::RUTA_IMAGENES_GALERIA . $this->getNombre();
    }
    function getUrlClientes() {
        return self::RUTA_IMAGENES_CLIENTES . $this->getNombre();
    }
	
    function getUrlGalerias() {
        return self::RUTA_IMAGENES_SUBIDAS . $this->getNombre();
    }
}

?>