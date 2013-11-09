<?php

# TODO
# 今は全選手共通なので選手個別に確率を持たせるよう変更

# ヒットの確率定義
$config['pa'] = array(
    'HITS'    => 12,
    'MISHITS' => 35,
    'OTHERS'  => 6,
    'PLATE_APPEARANCES' => 53
);

// 0~100: 本塁打, 101~120: 3塁打, 121~300: 2塁打, 301~1200: 単打
$config['hits'] = array(
    'SINGLES'  => 900,
    'DOUBLES'  => 180,
    'TRIPLES'  => 20,
    'HOMERUNS' => 100,
    'HITS_TOTAL'    => 1200, // 和
    'SINGLES_RANGE' => 300,  // HITS_TOTAL - SINGLES
    'DOUBLES_RANGE' => 120,  // HITS_TOTAL - (SINGLES+DOUBLES)
    'TRIPLES_RANGE' => 100   // HITS_TOTAL - (SINGLES+DOUBLES+TRIPLES)
);

// 凡打の内訳
// ゴロ、フライ、ライナー、併殺、三振
$config['mishits'] = array(
    'STRIKEOUTS'  => 25,
    'GROUND_OUTS' => 40,
    'LINER_OUTS'  => 8,
    'FLY_OUTS'    => 27,
    'GROUNDED_INTO_DOUBLE_PLAYS' => 0,
    'MISHITS_TOTAL' => 100 // 和
);

//その他の内訳
//四球、死球、犠打、犠飛、失策、野手選択
$config['others'] = array(
    'BASES_ON_BALLS'  => 18,
    'HIT_BY_PITCH'    => 2,
    'SACRIFICE_BUNTS' => 0,
    'SACRIFICE_FLIES' => 0,
    'ERRORS'          => 0,
    'FIELDERS_CHOICE' => 0,
    'OTHERS_TOTAL'    => 20 // 和
);

