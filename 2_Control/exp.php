
    <?php
  
    if($_POST['cod'] == "" || !isset($_POST['cod'] )) {
        header('Location: ./index.php');
    }
    $cod = $_POST['cod'];
    //trova tutte le risposte date , sbagliate ed esatte
    $sql = "SELECT course_accesses.code AS Codice, questions.id AS idDomanda ,questions.description AS Domanda  , quiz_answer_logs.`option` AS Risposta
            FROM course_accesses,questions,quiz_answer_logs 
            WHERE course_accesses.code = '$cod' AND 
                    quiz_answer_logs.question_id = questions.id AND 
                    quiz_answer_logs.course_access_id = course_accesses.id 
            GROUP BY 	questions.description";

    //trova tutte le risposte non date
    $sql_null = "SELECT id as idDomanda,description as Domanda ,answer_exact as Risposta FROM questions WHERE description  
        NOT IN (SELECT questions.description AS Domanda  
        FROM course_accesses,questions,quiz_answer_logs 
        WHERE course_accesses.code =  '$cod' AND 
                quiz_answer_logs.question_id = questions.id AND 
                quiz_answer_logs.course_access_id = course_accesses.id 
        GROUP BY 	questions.description)";

    //lista rispsote esatte    
    $sql2 = "SELECT answer_exact AS RispostaGiusta ,id FROM questions ";

    //restituisce i risultati del candidato
    $sql3 = "SELECT * FROM quiz_results WHERE code = '$cod'";

    $result = $conn->query($sql);
    $result_n = $conn->query($sql_null);
    $result2 = $conn->query($sql2);
    $result3 = $conn->query($sql3);

    while ($row_ex = $result2->fetch_assoc()) {
        $array_ex[$row_ex["id"]] = $row_ex["RispostaGiusta"];
    }
    if ($result->num_rows > 0) {
        while ($row_res = $result3->fetch_assoc()) {
            $codice = $row_res["code"];
            $punteggio = $row_res["final_rate"];
            $esatte = $row_res["exact_responses"];
            $errate = $row_res["failed_responses"];
            $nulle = $row_res["null_responses"];
        }
    } else {
        echo "";
    }
    ?>
