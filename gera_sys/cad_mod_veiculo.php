<meta charset='utf-8'><html><head><script>$().ready(function() {$("#dados").validate({rules:{id:{require : 1,type : int,maxlenght : 11},marca:{require : 1,type : varchar,maxlenght : 50},modelo:{require : 1,type : varchar,maxlenght : 100},ano:{require : 1,type : int,maxlenght : 11},cor:{require : 1,type : varchar,maxlenght : 50},placa:{require : 1,type : varchar,maxlenght : 8},km:{require : 1,type : bigint,maxlenght : 20},cdcliente:{require : 1,type : int,maxlenght : 11}},messages:{id:{maxlenght : O tamanho máximo para o campo id é de 11 digitos(s)},marca:{maxlenght : O tamanho máximo para o campo marca é de 50 carater(es)},modelo:{maxlenght : O tamanho máximo para o campo modelo é de 100 carater(es)},ano:{maxlenght : O tamanho máximo para o campo ano é de 11 digitos(s)},cor:{maxlenght : O tamanho máximo para o campo cor é de 50 carater(es)},placa:{maxlenght : O tamanho máximo para o campo placa é de 8 carater(es)},km:{maxlenght : O tamanho máximo para o campo km é de 20 },cdcliente:{maxlenght : O tamanho máximo para o campo cdcliente é de 11 digitos(s)}}})});</script></head><body><form id='cad_mod_veiculo' name='cad_mod_veiculo' action='' method='' class='form-horizontal'><fieldset><div class='control-group'><label class='control-label' for='ID'>ID</label><div class='controls'><input type='text' placeholder='' id ='id' name ='id' class='input-xlarge'></div></div><div class='control-group'><label class='control-label' for='Marca'>Marca</label><div class='controls'><input type='text' placeholder='' id ='marca' name ='marca' class='input-xlarge'></div></div><div class='control-group'><label class='control-label' for='Modelo'>Modelo</label><div class='controls'><input type='text' placeholder='' id ='modelo' name ='modelo' class='input-xlarge'></div></div><div class='control-group'><label class='control-label' for='Ano'>Ano</label><div class='controls'><input type='text' placeholder='' id ='ano' name ='ano' class='input-xlarge'></div></div><div class='control-group'><label class='control-label' for='Cor'>Cor</label><div class='controls'><input type='text' placeholder='' id ='cor' name ='cor' class='input-xlarge'></div></div><div class='control-group'><label class='control-label' for='Placa'>Placa</label><div class='controls'><input type='text' placeholder='' id ='placa' name ='placa' class='input-xlarge'></div></div><div class='control-group'><label class='control-label' for='Km'>Km</label><div class='controls'><input type='text' placeholder='' id ='km' name ='km' class='input-xlarge'></div></div><div class='control-group'><label class='control-label' for='Descrição'>Descrição</label><div class='controls'><input type='text' placeholder='' id ='cdcliente' name ='cdcliente' class='input-xlarge'></div></div></fieldset></form></body><html>