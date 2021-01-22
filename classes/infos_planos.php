<?php 
include __DIR__ . '/db.php';
// include __DIR__ . '/conn.php';

$sql = "SELECT
            p.id AS id_plano,
            p.nome AS nome_plano, 
            p.preco AS preco_plano, 
            (SELECT group_concat(i.descricao) 
                FROM infos i
                INNER JOIN infos_planos ip ON 
                    ip.id_infos = i.id
                WHERE ip.id_planos = p.id) AS infos_plano
            FROM 
            planos p";

$infos_planos = $db->query($sql)->fetch_all(MYSQLI_ASSOC);

$infos = [];
foreach($infos_planos as $value) {
    $info = explode(',', $value['infos_plano']);
    array_push($infos, ['id_plano' => $value['id_plano'], 'nome_plano' => $value['nome_plano'], 'preco_plano' => $value['preco_plano'], 'infos_plano' => $info]);
}

return $infos;