<?php
    if(isset($_POST["upload"])){
        //recebe os valores dos arquivos enviados pelo form
        $file= $_FILES["fileInput"];
        
        //Conta quantos arquivos foram enviados
        $numFile = count(array_filter($file["name"]));
        
        //Definir para qual pasta a imagem será enviada
        $folder = "uploads";

        //Tipos de arquivos suportados
        $permite = array("tif", "jpg", "png", "jpeg", "pdf", "docx");

        //Define valor máximo dos arquivos
        $maxSize = 1024 * 1024 * 10;

        //Mensagens de erro
        $msg = array();
        $erroMsg = array(
            1 => "O arquivo é maior que o limite de 10Mb",
            2 => "O upload do arquivo foi feito parcialmente",
            3 => "Não foi possível enviar o arquivo"
        );

        for($i=0; $i < $numFile; $i++){
            $name = $file["name"][$i]; //Pega o nome do arquivo
            $type = $file["type"][$i]; // Pega o tipo do arquivo
            $size = $file["size"][$i]; // Pega o tamanho do arquivo
            $error = $file["error"][$i]; // Pega os erros
            $tmp = $file["tmp_name"][$i]; // Pega um nome temporário para o arquivo

            $extensao = @end(explode(".", $name));

            date_default_timezone_set('America/Sao_Paulo'); //Adicionando data e hora no nome do arquivo para evitar nomes repetidos
            $data = date('dmYHis');
            $novoNome = rand() . $data. ".$extensao"; // Gera um novo nome para o arquivo

            if($error != 0 ){
                
                $msg[] = "<b>$name</b> " . $erroMsg[$error];

            }
            else if(!in_array($extensao, $permite)){

                $msg[] = "<b>$name</b> Erro: Tipo de arquivo não suportado";

            }
            else if($size > $maxSize){

                $msg[] = "<b>$name</b> Erro: Tamanho do arquivo maior que o suportado";

            }
            else{
                //Move o arquivo para a pasta
                if(move_uploaded_file($tmp, $folder."/".$novoNome)){
                    include_once("conexao.php");

                    $sql = "INSERT INTO arquivos (nameFile, extensaoFile)
                    VALUES ('$novoNome', '$extensao') ";

                    if($conn->query($sql) === TRUE){
                        $msg[] = "Upload realizado com sucesso";
                    }
                    else{
                        $msg[] = "Erro ao fazer upload";
                    }
                }
                else{
                    $msg[] = "Ocorreu algum erro ao fazer upload do arquivo";
                }
            }
        }

        foreach($msg as $value){
            echo $value."<br>";
        }

    }else{
        echo "Nada";
    }

?>