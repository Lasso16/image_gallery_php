<?php

require_once __DIR__ . '/../exceptions/FileException.class.php';

class File
{
    private $file;
    private $fileName;

    /**
     * param string $fileName
     * param array $arrTypes
     * @throws FileException
     */
    public function __construct(string $fileName, array $arrTypes)
    {
        $this->file = $_FILES[$fileName];
        $this->fileName = '';
        if (!isset($this->file)) {
            throw new FileException('Debes seleccionar un fichero');
        }
        if ($this->file['error'] !== UPLOAD_ERR_OK) {

            switch ($this->file['error']) {
                case UPLOAD_ERR_INI_SIZE:
                    throw new FileException('El fichero es demasiado grande');

                case UPLOAD_ERR_FORM_SIZE:
                    throw new FileException('El fichero es demasiado grande');
                case UPLOAD_ERR_PARTIAL:
                    throw new FileException('No se ha podido subir el fichero completo');
                default:
                    throw new FileException('No se ha podido subir el fichero');
            }
        }

        if (in_array($this->file['type'], $arrTypes) === false) {
            throw new FileException('Tipo de fichero no soportado');
        }
    }
    public function getFileName()
    {
        return $this->fileName;
    }


    /**
     * @param string $rutaDestino
     * @return void
     * @throws FileException
     */
    public function saveUploadFile(string $rutaDestino)
    {
    
        if (is_uploaded_file($this->file['tmp_name']) === false)
            throw new FileException('El archivo no ha sido subido mediante un formulario.');
        $this->fileName = $this->file['name'];
        $ruta = $rutaDestino . $this->fileName;
        
        if (is_file($ruta) === true) {
            $idUnico = time();
            $this->fileName = $idUnico . "_" . $this->fileName;
            $ruta = $rutaDestino . $this->fileName;
        }
        if (move_uploaded_file($this->file['tmp_name'], $ruta) === false)
    throw new FileException('No se puede mover el archivo a su destino');
    }
}
