<?php 
    class VideoDetailsFormProvider {
        
        private $con;
        
        public function __construct($con) {
            $this->con = $con;
        }

        public function createUploadForm() {
            $fileInput = $this->createFileInput();
            $titleInput = $this->createTitleInput();
            $descriptionInput = $this->createDescriptionInput();
            $privacyInput = $this->createPrivacyInput();
            $categoriesInput = $this->createCategoriesInput();
            $uploadButton = $this->createUploadButton();

            return "<form action='processing.php' method='POST' enctype='multipart/form-data'>
                        $fileInput
                        $titleInput
                        $descriptionInput
                        $privacyInput
                        $categoriesInput
                        $uploadButton
                    </form>";
        }

        private function createFileInput() {
            /* If you use a label, it must match the input id: <label for='exampleFormControlFile1'>Your file</label> */
            return "<div class='form-group'>
                        <input type='file' class='form-control-file' name='fileInput' required>
                    </div>";
        }

        private function createTitleInput() {
            return "<div class='form-group'>
                        <input class='form-control' type='text' placeholder='Title' name='titleInput'>
                    </div>";
        }

        
        private function createDescriptionInput() {
            return "<div class='form-group'>
                        <textarea class='form-control' placeholder='Description' name='descriptionInput' rows='3'></textarea>
                    </div>";
        }

        private function createPrivacyInput() {
            return "<div class='form-group'>
                        <select class='form-control' name='privacyInput'>
                            <option value='0'>Private</option>
                            <option value='1'>Public</option>
                        </select>
                    </div>";   
        }

        private function createCategoriesInput() {
            $categoryQuery = $this->con->prepare("SELECT * FROM categories");
            $categoryQuery->execute();

            $html = "<div class='form-group'>
            <select class='form-control' name='categoryInput'>";

            while($row = $categoryQuery->fetch(PDO::FETCH_ASSOC)) { //using the query we specified, we scroll through the key-value array
                $name = $row["name"];
                $id = $row["id"];
                $html .= "<option value=$id>$name</option>"; //equivalent to $html = $html . VALUE
                //echo $row["name"], "<br>";
            }

            $html .= "
                </select>
            </div>";

            return $html;
        }

        private function createUploadButton() {
            return "<button type='submit' class='btn btn-primary' name='uploadButton'>Upload</button>";
        }
}
?>