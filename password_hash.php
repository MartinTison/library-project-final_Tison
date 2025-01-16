<?php
// Vytvorenie hashovaného hesla pomocou funkcie password_hash
$hash = password_hash("MojeHeslo123", PASSWORD_DEFAULT);

// Zobrazenie vygenerovaného hashovaného hesla
echo $hash;