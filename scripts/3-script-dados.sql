/*
Criação de acesso para Administrador (user:admin / senha:admin)
IMPORTANTE: Após logon no sistema, alterar para senha personalizada

--Substituir os parâmetros:
<db>: nome do banco de dados
*/

use <db>;

INSERT INTO `login` (`nom_usuario`, `nom_senha`, `salt`, `ind_status`) VALUES
('admin', 'd0c8c27e8c10f920f50f39cdcb9e2914070775c0005ea362536ff0024d4fe28d18c044fad939af4a4879e9e27cc5d041d3168f6f52968c0f46c4d8955653c778', 'a6ed55389f671afcc85ea02962784aa6c1eb4a3616abfd68ee00557f60e9f740cc0b20b9aa5a259e39cdee1f53935cbc9de70230ccedc82ded0a7ecd9bffc0e0', 'A');

INSERT INTO gab_cargo_politico (nom_car_pol,ind_car_pol) VALUES ('Vereador','A');
INSERT INTO gab_cargo_politico (nom_car_pol,ind_car_pol) VALUES ('Vereadora','A');

