<?php
    $connect = mysqli_connect("localhost", "root", "", "wolfz");
    $izlaz = '';
    if(isset($_POST["izvestaj"]))
    {
        $sql = "SELECT * FROM mediji ORDER BY id ASC";
        $result = mysqli_query($connect, $sql);
        if (mysqli_num_rows($result) > 0)
        {
            $izlaz .= '
                <table class="table">
                <tr>
                    <th>ID</th>
                    <th>Naziv</th>
                    <th>Zemlja porijekla</th>
                    <th>Karakter</th>
                    <th>Datum osnivanja</th>
                </tr>
            ';
            while($row = mysqli_fetch_array($result))
            {
                $izlaz .= '
                    <tr>
                        <td>' .$row["id"].'</td>
                        <td>' .$row["naziv"].'</td>
                        <td>' .$row["zemlja"].'</td>
                        <td>' .$row["karakter_medija"].'</td>
                        <td>' .$row["god_osnivanja"].'</td>
                    </tr>
                ';
            }
            $izlaz .= '</table>';
            header("Content-Type: application/xls");
            header("Content-Disposition: attachment; filename = izvestaj.xls");
            echo $izlaz;
        }
    }