<?php
      require_once "../Domena/head.php"; // menu
  ?>

    <div class="content">
        <div class="pole">
            <?php
                    if(isset($_GET['activate']))
                        {
                            $key = filter_input(INPUT_GET, 'activate');
                             require_once "../Admin/database.php";
                        
                            $query = $db->prepare("SELECT kod FROM DUsers WHERE kod = :kod ");
                            $query->bindValue(':kod', $key, PDO::PARAM_STR);
                            $query->execute();	
                               
                            if($query->rowCount()>0)
                                {
                                    $keyn = password_hash(rand(123, 12345), PASSWORD_DEFAULT);
                                
                                    $query = $db->prepare("UPDATE DUsers SET status = 'AKT', kod = :keyg  WHERE kod = :kod ");
                                    $query->bindValue(':kod', $key, PDO::PARAM_STR);
                                    $query->bindValue(':keyg', $keyn, PDO::PARAM_STR);
                                    $query->execute();	
                                 

                                    echo('<p>Dziękujemy za rejestrację w serwisie i aktywacje!  Możesz już zalogować się na swoje konto!</p>
                                        <a href="index"><button class="btn-prim">Strona główna</button></a>
                                        ');


                                    }
                                    else
                                    {
                                        echo('<p class ="error">Błedny klucz </p>
                                        <a href="index"><button class="btn-prim">Strona główna</button></a>');
                                    }
                                
                        }

                ?>

        </div>
    </div>


    <script src="js/jquery.min.js"></script>
    <script src="js/stickymenu.js"></script>

    </body>

    </html>
