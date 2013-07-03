<?php
include "config/main.php";
class Image{
    private $_settings = array(
        'upload_path' => 'upload',
        'allowed_types' => array('png','jpg'),
        'default_prefix' => 'image',
        'max_on_page' => 100,
    );
    public $message = "";
    public function __construct(){
        global $_API_SETTINGS;
        if(isset($_API_SETTINGS) && !empty($_API_SETTINGS)){
            $this->_settings = array_merge($this->_settings,$_API_SETTINGS);
        }
    }

    public function upload($file){
        if(isset($file['image']) && !$file['image']['error']){
            $db = Database::getInstance();
            $id = intval($db->getLastId("image"));
            $upload_path = $this->_settings['upload_path'];
            //get extension
            $ext = pathinfo($file['image']['name'], PATHINFO_EXTENSION);
            if(in_array($ext,$this->_settings['allowed_types'])){
                $id++;//increment for next image
                $image_name = "{$this->_settings['default_prefix']}_{$id}.{$ext}";
                if (move_uploaded_file($file['image']['tmp_name'], "{$upload_path}/{$image_name}")) {
                    $db->insert("image",array('name' => $image_name ,'time'=>time()));
                    $this->message = "Upload complete!";
                 } else {
                    $this->message = "Upload failed!";
                 }
            }
        }else{
            $this->message = "Please add image";
        }
    }

    public function getAllImages(){
        $db = Database::getInstance();
        $res = $db->get_where("image","",$this->_settings['max_on_page'],"order by time desc")->result();
        return $res;
    }

    public function deleteImage($id){
        $db = Database::getInstance();
        $name = $db->get_where("image"," WHERE id = {$id} ",1,"order by time desc")->result();
        if(isset($name[0]['name'])){
            $name = $name[0]['name'];
            unlink("{$this->_settings['upload_path']}/{$name}");
        }
        return $db->delete("image",$id);
    }

    public function getImageUrl($name){
        $upload_path = $this->_settings['upload_path'];
        return "{$upload_path}/{$name}";
    }

    public function validate($request){
        if(isset($request['upload'])){
            $this->upload($_FILES);
        }
        if(isset($request['delete']) && is_numeric($request['delete'])){
            $this->deleteImage($request['delete']);
        }
    }
}

?>