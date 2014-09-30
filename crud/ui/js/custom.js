$(function () {
    //Cliente
    $(document).on("click", "a#cliente_list", function () {
        getClienteList(this);
    });
    $(document).on("click", "a#create_cliente_form", function () {
        getAddFormCliente(this);
    });
    $(document).on("click", "a.edit_cliente", function () {
        getEditFormCliente(this);
    });
    $(document).on("click", "button#add_cliente", function () {
        addCliente(this);
    });
    $(document).on("click", "button#save_cliente", function () {
        saveCliente(this);
    });
    $(document).on("click", "a.delete_cliente", function () {
        deleteClienteConfirmation(this);
    });
    $(document).on("click", "button.delete_cliente", function () {
        deleteCliente(this);
    });

    //Veiculo
    $(document).on("click", "a#veiculo_list", function () {
        getVeiculoList(this);
    });
    $(document).on("click", "a#create_veiculo_form", function () {
        getAddFormVeiculo(this);
    });
    $(document).on("click", "a.edit_veiculo", function () {
        getEditFormVeiculo(this);
    });
    $(document).on("click", "button#add_veiculo", function () {
        addVeiculo(this);
    });
    $(document).on("click", "button#save_veiculo", function () {
        saveVeiculo(this);
    });
    $(document).on("click", "a.delete_veiculo", function () {
        deleteVeiculoConfirmation(this);
    });
    $(document).on("click", "button.delete_veiculo", function () {
        deleteVeiculo(this);
    });
    $(document).on("click", "a#busca_veiculo", function () {
        MostraFormBuscaVeiculos();
    });

    //Orcamento
    $(document).on("click", "a#orcamento_list", function () {
        getOrcamentoList(this);
    });
    $(document).on("click", "a#create_orcamento_form", function () {
        getAddFormOrcamento(this);
    });
    $(document).on("click", "a.edit_orcamento", function () {
        getEditFormOrcamento(this);
        $('#table_orc').calx();            
    });
    $(document).on("click", "button#add_orcamento", function () {
        addOrcamento(this);
    });
    $(document).on("click", "button#save_orcamento", function () {
        saveOrcamento(this);
    });
    $(document).on("click", "a.delete_orcamento", function () {
        deleteOrcamentoConfirmation(this);
    });
    $(document).on("click", "button.delete_orcamento", function () {
        deleteOrcamento(this);
    });
    $(document).on("click", "a.add_itemorcamento", function () {
        AddNewLineItemOrcamento(this);
    });
    $(document).on("keyup", "#table_orc td", function (event) {
        event.preventDefault();        
    });

    //##--calcula a tabela do orçamento--##
    $(document).on('focusout','[name*="desconto_"]',function(){
        $('#table_orc').calx();    
        AtualizaValoresOrcamento();     
    });    


    //Busca
    $(document).on("keydown", "input#edBusca", function () {
        busca(this);
    });
    $(document).on("click", "#selecao_busca", function () {
        MarcaSelecionado(this);
    });    
    $(document).on("click", "#busca_modal td", function () {
        MarcaSelecionado(this);
    }); 

});


/////// CLIENTES  //////////////////////////////////////////
/////// CLIENTES  //////////////////////////////////////////
/////// CLIENTES  //////////////////////////////////////////
/////// CLIENTES  //////////////////////////////////////////
/////// CLIENTES  //////////////////////////////////////////

function MostraFormBuscaVeiculos() {
    getlistaVeiculosBusca('');
    $("#busca_modal").modal("show");
    $("#busca_modal input#cliente_id").attr('value',$('#idcliente').attr('value'));  
}


function deleteClienteConfirmation(element) {
    $("#delete_confirm_modal").modal("show");
    $("#delete_confirm_modal h3#myModalLabel").text('Exluir este cliente?');
    $("#delete_confirm_modal input#cliente_id").val($(element).attr('cliente_id'));
}

function deleteCliente(element) {

    var Cliente = new Object();
    Cliente.id = $("#delete_confirm_modal input#cliente_id").val();

    var clienteJson = JSON.stringify(Cliente);

    $.post('Controller.php',
        {
            action: 'delete_cliente',
            cliente: clienteJson
        },
        function (data, textStatus) {
            getClienteList(element);
            $("#delete_confirm_modal").modal("hide");
        },
        "json"
    );
}

function getClienteList(element) {

    $('#indicator').show();

    $.post('Controller.php',
        {
            action: 'get_clientes'
        },
        function (data, textStatus) {
            renderClienteList(data);
            $('#indicator').hide();
        },
        "json"
    );
}

function renderClienteList(jsonData) {
    var table = '<a href="javascript:void(0);" id="create_cliente_form" class="add_button btn "><i class="icon-plus-sign icon-blck"></i> Novo Cliente </a></br>';
    table += '<table width="600" cellpadding="8" class="table table-hover table-bordered"><thead><tr><th scope="col">ID</th><th scope="col">Nome</th><th scope="col">CPF</th><th scope="col">Cidade</th><th scope="col">UF</th><th scope="col">Email</th><th scope="col">Telefone Celular</th><th scope="col" colspan="2" >Ações</th></tr></thead><tbody>';
    var total = 0;
    $.each(jsonData, function (index, cliente) {
        table += '<tr>';
        table += '<td class="edit" field="id"   cliente_id="' + cliente.id + '">' + cliente.id + '</td>';
        table += '<td class="edit" field="nome"   cliente_id="' + cliente.id + '">' + cliente.nome + '</td>';
        table += '<td class="edit" field="cpf"    cliente_id="' + cliente.id + '">' + cliente.cpf + '</td>';
        table += '<td class="edit" field="cidade" cliente_id="' + cliente.id + '">' + cliente.cidade + '</td>';
        table += '<td class="edit" field="uf"     cliente_id="' + cliente.id + '">' + cliente.uf + '</td>';
        table += '<td class="edit" field="email"  cliente_id="' + cliente.id + '">' + cliente.email + '</td>';
        table += '<td class="edit" field="telefonecelular" cliente_id="' + cliente.id + '">' + cliente.telefonecelular + '</td>';
        table += '<td><a href="javascript:void(0);" id="' + cliente.id + '" cliente_id="' + cliente.id + '" class="edit_cliente btn btn-info"><i class="icon-folder-open icon-white"></i></a> ';
        table += ' <a href="javascript:void(0);" id="' + cliente.id + '" cliente_id="' + cliente.id + '" class="delete_cliente btn btn-danger"><i class="icon-remove icon-white"></i></a></td>';
        table += '</tr>'
        total = index;
    });
    if (total != 0){
        table += '<tr><td colspan=9>Total Registros: ' + (total + 1) + '</td></tr>';
    }else{
        table += '<tr><td colspan=9>Total Registros: ' + (total) + '</td></tr>';        
    }

    table += '</tbody></table>';


    $('div#content').html(table);
}



function addCliente(element) {

    $('#indicator').show();

    var Cliente = new Object();
    Cliente.nome = $('input#nome').val();
    Cliente.nascimento = $('input#nascimento').val();
    Cliente.cpf = $('input#cpf').val();
    Cliente.rg = $('input#rg').val();
    Cliente.email = $('input#email').val();
    Cliente.telefonecelular = $('input#telefonecelular').val();
    Cliente.cidade = $('input#cidade').val();
    Cliente.uf = $('input#uf').val();
    Cliente.bairro = $('input#bairro').val();
    Cliente.cep = $('input#cep').val();
    Cliente.complemento = $('input#complemento').val();
    Cliente.pais = $('input#pais').val();
    Cliente.endereco = $('input#endereco').val();

    var clienteJson = JSON.stringify(Cliente);

    $.post('Controller.php',
        {
            action: 'add_cliente',
            cliente: clienteJson
        },
        function (data) {
            if (data == 0) {
                getClienteList(element);
                $('#indicator').hide();
            } else {
                $('#' + data.campo).focus();
                alert(data.msg_erro);
                $('#indicator').hide();
            }
        },
        "json"
    );
}

function saveCliente(element) {

    $('#indicator').show();

    var Cliente = new Object();
    //----------------------------------
    Cliente.id = $('input#idcliente').attr('value');
    Cliente.nome = $('input#nome').val();
    Cliente.nascimento = $('input#nascimento').val();
    Cliente.cpf = $('input#cpf').val();
    Cliente.rg = $('input#rg').val();
    Cliente.email = $('input#email').val();
    Cliente.telefonecelular = $('input#telefonecelular').val();
    Cliente.cidade = $('input#cidade').val();
    Cliente.uf = $('input#uf').val();
    Cliente.bairro = $('input#bairro').val();
    Cliente.cep = $('input#cep').val();
    Cliente.complemento = $('input#complemento').val();
    Cliente.pais = $('input#pais').val();
    Cliente.endereco = $('input#endereco').val();

    var clienteJson = JSON.stringify(Cliente);

    $.post('Controller.php',
        {
            action: 'update_cliente_data',
            cliente: clienteJson
        },
        function (data, textStatus) {
            getClienteList(element);
            $('#indicator').hide();
        },
        "json"
    );
}

function getEditFormCliente(element) {

    var
        form = '';
    form += '<div class="input-prepend">';
    form += '<span class="add-on"><i class="icon-user icon-black"></i>ID</span>';
    form += '<input type="text" id="idcliente" name="idcliente" value="" class="input-xlarge" />';
    form += '</div><br/><br/>';

    form += '<div class="input-prepend">';
    form += '<span class="add-on"><i class="icon-user icon-black"></i>Nome</span>';
    form += '<input type="text" id="nome" name="nome" value="" class="input-xlarge" />';
    form += '</div><br/><br/>';

    form += '<div class="input-prepend">';
    form += '<span class="add-on"><i class="icon-home icon-black"></i>Nascimento</span>';
    form += '<input type="text" id="nascimento" name="nascimento" class="input-xlarge" />';
    form += '</div><br/><br/>';

    form += '<div class="input-prepend">';
    form += '<span class="add-on"><i class="icon-home icon-black"></i>CPF</span>';
    form += '<input type="text" id="cpf" name="cpf" class="input-xlarge"/>';
    form += '</div><br/><br/>';

    form += '<div class="input-prepend">';
    form += '<span class="add-on"><i class="icon-home icon-black"></i>RG</span>';
    form += '<input type="text" id="rg" name="rg" class="input-xlarge"/>';
    form += '</div><br/><br/>';

    form += '<div class="input-prepend">';
    form += '<span class="add-on"><i class="icon-envelope icon-black"></i>Email</span>';
    form += '<input type="text" id="email" name="email" value="" class="input-xlarge" />';
    form += '</div><br/><br/>';

    form += '<div class="input-prepend">';
    form += '<span class="add-on"><i class="icon-headphones icon-black"></i>Telefone</span>';
    form += '<input type="text" id="telefonecelular" name="telefonecelular" value="" class="input-xlarge" />';
    form += '</div><br/><br/>';

    form += '<div class="input-prepend">';
    form += '<span class="add-on"><i class="icon-home icon-black"></i>Endereco</span>';
    form += '<input type="text" id="endereco" name="endereco" class="input-xlarge"/>';
    form += '</div><br/><br/>';

    form += '<div class="input-prepend">';
    form += '<span class="add-on"><i class="icon-home icon-black"></i>UF</span>';
    form += '<input type="text" id="uf" name="uf" class="input-xlarge"/>';
    form += '</div><br/><br/>';

    form += '<div class="input-prepend">';
    form += '<span class="add-on"><i class="icon-home icon-black"></i>Cidade</span>';
    form += '<input type="text" id="cidade" name="cidade" class="input-xlarge"/>';
    form += '</div><br/><br/>';

    form += '<div class="input-prepend">';
    form += '<span class="add-on"><i class="icon-home icon-black"></i> Bairro</span>';
    form += '<input type="text" id="bairro" name="bairro" class="input-xlarge"/>';
    form += '</div><br/><br/>';

    form += '<div class="input-prepend">';
    form += '<span class="add-on"><i class="icon-home icon-black"></i> CEP</span>';
    form += '<input type="text" id="cep" name="cep" class="input-xlarge"/>';
    form += '</div><br/><br/>';

    form += '<div class="input-prepend">';
    form += '<span class="add-on"><i class="icon-home icon-black"></i> Compl.</span>';
    form += '<input type="text" id="complemento" name="complemento" class="input-xlarge"/>';
    form += '</div><br/><br/>';

    form += '<div class="input-prepend">';
    form += '<span class="add-on"><i class="icon-home icon-black"></i> País</span>';
    form += '<input type="text" id="pais" name="pais" class="input-xlarge"/>';
    form += '</div><br/><br/>';

    form += '<div class="novo">';
    form += '<span class="add-on"><i class="icon-home icon-black"></i> Veículo(s)</span>';
	form += '<div id="divveiculos" name="divveiculos" />';    
    form += '<a href="javascript:void(0);" id="busca_veiculo"  class=" btn btn-info"><i class="icon-folder-open icon-white"></i> Seleciona Veículo</a>';
    form += '</div><br/><br/>';


    form += '<div class="control-group">';
    form += '<div class="">';
    form += '<button type="button" id="save_cliente" class="btn btn-primary"><i class="icon-ok icon-white"></i> Confirma</button>';
    form += '</div>';
    form += '</div>';

    $('div#content').html(form);
////////////////////////////////
	// esconde campos
////////////////////////////////]
	$('div#content #nomeveiculo').css('display','none');

    //preenche os valores
////////////////////////////////		

    $('#indicator').show();


    $.post('Controller.php',
        {
            action: 'get_cliente',
            cliente: element.id
        },
        function (data) {
            var data = data[0];
            $('input#idcliente').attr('value', data.id);
            $('input#nome').attr('value', data.nome);
            $('input#nascimento').attr('value', data.nascimento);
            $('input#cpf').attr('value', data.cpf);
            $('input#rg').attr('value', data.rg);
            $('input#email').attr('value', data.email);
            $('input#telefonecelular').attr('value', data.telefonecelular);
            $('input#cidade').attr('value', data.cidade);
            $('input#uf').attr('value', data.uf);
            $('input#bairro').attr('value', data.bairro);
            $('input#cep').attr('value', data.cep);
            $('input#complemento').attr('value', data.complemento);
            $('input#pais').attr('value', data.pais);
            $('input#endereco').attr('value', data.endereco);
        },
        "json"
    );

    //pega relacionamento cliente com veiculo e coloca no form.
    $.post('Controller.php',
        {
            action: 'get_cliente_veiculo',
            cliente: element.id
        },
        function (data) {
            CriarGridVeiculosCliente(data);
        },
        "json"
    );

    $('#indicator').hide();
}


function CriarGridVeiculosCliente(ConjuntoDados){

    table = '<table width="250" cellpadding="3" class="table table-hover table-bordered">';
    table += '		<thead>';
    table += '			<tr style="font-size:8;">';
    table += '				<th scope="col">Marca</th>';
    table += '				<th scope="col">Modelo</th>';
    table += '				<th scope="col">Placa</th>';
    table += '			</tr>';
    table += '		</thead>';
    table += '		<tbody>';

    $.each(ConjuntoDados, function (index, veiculo) {
        table += '		<tr >';
        table += '			<td class="edit" field="marca"  veiculo_id="' + veiculo.id + '">' + veiculo.marca + '</td>';
        table += '			<td class="edit" field="modelo" veiculo_id="' + veiculo.id + '">' + veiculo.modelo + '</td>';
        table += '			<td class="edit" field="placa"  veiculo_id="' + veiculo.id + '">' + veiculo.placa + '</td>';
        table += '		</tr>';
    });

    table += '	</tbody>';
    table += '	</table>';

    $('div#content #divveiculos').html(table);    
}

function getAddFormCliente(element) {

    var
    form = '<div class="input-prepend">';
    form += '<span class="add-on"><i class="icon-user icon-black"></i> Nome</span>';
    form += '<input type="text" id="nome" name="nome" value="" class="input-xlarge" />';
    form += '</div><br/><br/>';

    form += '<div class="input-prepend">';
    form += '<span class="add-on"><i class="icon-home icon-black"></i>Nascimento</span>';
    form += '<input type="text" id="nascimento" name="nascimento" class="input-xlarge" />';
    form += '</div><br/><br/>';

    form += '<div class="input-prepend">';
    form += '<span class="add-on"><i class="icon-home icon-black"></i> CPF</span>';
    form += '<input type="text" id="cpf" name="cpf" class="input-xlarge"/>';
    form += '</div><br/><br/>';

    form += '<div class="input-prepend">';
    form += '<span class="add-on"><i class="icon-home icon-black"></i> RG</span>';
    form += '<input type="text" id="rg" name="rg" class="input-xlarge"/>';
    form += '</div><br/><br/>';

    form += '<div class="input-prepend">';
    form += '<span class="add-on"><i class="icon-envelope icon-black"></i> Email</span>';
    form += '<input type="text" id="email" name="email" value="" class="input-xlarge" />';
    form += '</div><br/><br/>';

    form += '<div class="input-prepend">';
    form += '<span class="add-on"><i class="icon-headphones icon-black"></i> Telefone</span>';
    form += '<input type="text" id="telefonecelular" name="telefonecelular" value="" class="input-xlarge" />';
    form += '</div><br/><br/>';

    form += '<div class="input-prepend">';
    form += '<span class="add-on"><i class="icon-home icon-black"></i>Endereco</span>';
    form += '<input type="text" id="endereco" name="endereco" class="input-xlarge"/>';
    form += '</div><br/><br/>';

    form += '<div class="input-prepend">';
    form += '<span class="add-on"><i class="icon-home icon-black"></i>UF</span>';
    form += '<input type="text" id="uf" name="uf" class="input-xlarge"/>';
    form += '</div><br/><br/>';

    form += '<div class="input-prepend">';
    form += '<span class="add-on"><i class="icon-home icon-black"></i>Cidade</span>';
    form += '<input type="text" id="cidade" name="cidade" class="input-xlarge"/>';
    form += '</div><br/><br/>';

    form += '<div class="input-prepend">';
    form += '<span class="add-on"><i class="icon-home icon-black"></i> Bairro</span>';
    form += '<input type="text" id="bairro" name="bairro" class="input-xlarge"/>';
    form += '</div><br/><br/>';

    form += '<div class="input-prepend">';
    form += '<span class="add-on"><i class="icon-home icon-black"></i> CEP</span>';
    form += '<input type="text" id="cep" name="cep" class="input-xlarge"/>';
    form += '</div><br/><br/>';

    form += '<div class="input-prepend">';
    form += '<span class="add-on"><i class="icon-home icon-black"></i> Compl.</span>';
    form += '<input type="text" id="complemento" name="complemento" class="input-xlarge"/>';
    form += '</div><br/><br/>';

    form += '<div class="input-prepend">';
    form += '<span class="add-on"><i class="icon-home icon-black"></i> País</span>';
    form += '<input type="text" id="pais" name="pais" class="input-xlarge"/>';
    form += '</div><br/><br/>';

    form += '<div class="control-group">';
    form += '<div class="">';
    form += '<button type="button" id="add_cliente" class="btn btn-primary"><i class="icon-ok icon-white"></i> Confirma</button>';
    form += '</div>';
    form += '</div>';

    $('div#content').html(form);
}

/////// VEICULOS  //////////////////////////////////////////
/////// VEICULOS  //////////////////////////////////////////
/////// VEICULOS  //////////////////////////////////////////
/////// VEICULOS  //////////////////////////////////////////

function deleteVeiculoConfirmation(element) {
    $("#delete_confirm_modal").modal("show");
    $("#delete_confirm_modal h3#myModalLabel").text('Exluir este veiculo?');
    $("#delete_confirm_modal input#cliente_id").val($(element).attr('cliente_id'));
}

function deleteVeiculo(element) {

    var Veiculo = new Object();
    Veiculo.id = $("#delete_confirm_modal input#cliente_id").val();

    var veiculoJson = JSON.stringify(Veiculo);

    $.post('Controller.php',
        {
            action: 'delete_veiculo',
            veiculo: veiculoJson
        },
        function (data, textStatus) {
            getVeiculoList(element);
            $("#delete_confirm_modal").modal("hide");
        },
        "json"
    );
}




function getVeiculoList(element) {

    $('#indicator').show();

    $.post('Controller.php',
        {
            action: 'get_veiculos'
        },
        function (data, textStatus) {
            renderVeiculoList(data);
            $('#indicator').hide();
        },
        "json"
    );
}

function renderVeiculoList(jsonData) {
    var table = '<a href="javascript:void(0);" id="create_veiculo_form" class="add_button btn "><i class="icon-plus-sign icon-blck"></i> Novo Veículo </a></br>';
    table += '<table width="600" cellpadding="7" class="table table-hover table-bordered"><thead><tr><th scope="col">ID</th><th scope="col">Marca</th><th scope="col">Modelo</th><th scope="col">Ano</th><th scope="col">Cor</th><th scope="col">Placa</th><th scope="col">KM</th><th scope="col" colspan="2" >Ações</th></tr></thead><tbody>';
    var total = 0;
    $.each(jsonData, function (index, veiculo) {
        table += '<tr>';
        table += '<td class="edit" field="id"   veiculo_id="' + veiculo.id + '">' + veiculo.id + '</td>';
        table += '<td class="edit" field="marca"   veiculo_id="' + veiculo.id + '">' + veiculo.marca + '</td>';
        table += '<td class="edit" field="modelo"    veiculo_id="' + veiculo.id + '">' + veiculo.modelo + '</td>';
        table += '<td class="edit" field="ano" veiculo_id="' + veiculo.id + '">' + veiculo.ano + '</td>';
        table += '<td class="edit" field="cor"     veiculo_id="' + veiculo.id + '">' + veiculo.cor + '</td>';
        table += '<td class="edit" field="placa"  veiculo_id="' + veiculo.id + '">' + veiculo.placa + '</td>';
        table += '<td class="edit" field="km" veiculo_id="' + veiculo.id + '">' + veiculo.km + '</td>';
        table += '<td><a href="javascript:void(0);" id="' + veiculo.id + '" veiculo_id="' + veiculo.id + '" class="edit_veiculo btn btn-info"><i class="icon-folder-open icon-white"></i></a> ';
        table += ' <a href="javascript:void(0);" id="' + veiculo.id + '" veiculo_id="' + veiculo.id + '" class="delete_veiculo btn btn-danger"><i class="icon-remove icon-white"></i></a></td>';
        table += '</tr>'
        total = index;
    });
    if (total != 0){
        table += '<tr><td colspan=9>Total Registros: ' + (total + 1) + '</td></tr>';
    }else{
        table += '<tr><td colspan=9>Total Registros: ' + (total) + '</td></tr>';        
    }

    table += '</tbody></table>';


    $('div#content').html(table);
}

function renderVeiculoListBusca(jsonData) {
    var
        table = '<table width="250" cellpadding="3" class="table table-hover table-bordered table-sieve">';
    table += '		<thead>';
    table += '			<tr>';
    table += '				<th scope="col">Marca</th>';
    table += '				<th scope="col">Modelo</th>';
    table += '				<th scope="col">Placa</th>';
    table += '			</tr>';
    table += '		</thead>';
    table += '		<tbody>';
    $.each(jsonData, function (index, veiculo) {
        table += '		<tr>';
        table += '			<td class="edit" field="marca"  veiculo_id="' + veiculo.id + '">' + veiculo.marca + '</td>';
        table += '			<td class="edit" field="modelo" veiculo_id="' + veiculo.id + '">' + veiculo.modelo + '</td>';
        table += '			<td class="edit" field="placa"  veiculo_id="' + veiculo.id + '">' + veiculo.placa + '</td>';
        table += '		</tr>';
    });
    table += '	</tbody>';
    table += '	</table>';

    $("#busca_modal #conteudo").html(table);
}

function getlistaVeiculosBusca(busca) {

    $("#busca_modal h3#myModalLabel").text("Busca Veículos");

    $.post('Controller.php',
        {
            action: 'get_busca_veiculo',
            sbusca: busca
        },
        function (data, textStatus) {
            renderVeiculoListBusca(data);
        },
        "json"
    );
}


function getAddFormVeiculo(element) {

    var
    form = '<div class="input-prepend">';
    form += '<span class="add-on"><i class="icon-user icon-black"></i> Marca</span>';
    form += '<input type="text" id="marca" name="marca" value="" class="input-xlarge" />';
    form += '</div><br/><br/>';

    form += '<div class="input-prepend">';
    form += '<span class="add-on"><i class="icon-home icon-black"></i>Modelo</span>';
    form += '<input type="text" id="modelo" name="modelo" class="input-xlarge" />';
    form += '</div><br/><br/>';

    form += '<div class="input-prepend">';
    form += '<span class="add-on"><i class="icon-home icon-black"></i>Ano</span>';
    form += '<input type="text" id="ano" name="ano" class="input-xlarge"/>';
    form += '</div><br/><br/>';

    form += '<div class="input-prepend">';
    form += '<span class="add-on"><i class="icon-home icon-black"></i>Cor</span>';
    form += '<input type="text" id="cor" name="cor" class="input-xlarge"/>';
    form += '</div><br/><br/>';

    form += '<div class="input-prepend">';
    form += '<span class="add-on"><i class="icon-envelope icon-black"></i>Placa</span>';
    form += '<input type="text" id="placa" name="placa" value="" class="input-xlarge" />';
    form += '</div><br/><br/>';

    form += '<div class="input-prepend">';
    form += '<span class="add-on"><i class="icon-headphones icon-black"></i>KM</span>';
    form += '<input type="text" id="km" name="km" value="" class="input-xlarge" />';
    form += '</div><br/><br/>';

    form += '<div class="control-group">';
    form += '<div class="">';
    form += '<button type="button" id="add_veiculo" class="btn btn-primary"><i class="icon-ok icon-white"></i> Confirma</button>';
    form += '</div>';
    form += '</div>';

    $('div#content').html(form);
}

function addVeiculo(element) {

    $('#indicator').show();


    var Veiculo = new Object();
    Veiculo.marca = $('input#marca').val();
    Veiculo.modelo = $('input#modelo').val();
    Veiculo.ano = $('input#ano').val();
    Veiculo.cor = $('input#cor').val();
    Veiculo.placa = $('input#placa').val();
    Veiculo.km = $('input#km').val();

    var veiculoJson = JSON.stringify(Veiculo);

    $.post('Controller.php',
        {
            action: 'add_veiculo',
            veiculo: veiculoJson
        },
        function (data) {
            if (data == 0) {
                getVeiculoList(element);
                $('#indicator').hide();
            } else {
                $('#' + data.campo).focus();
                alert(data.msg_erro);
                $('#indicator').hide();
            }
        },
        "json"
    );
}

function saveVeiculo(element) {

    $('#indicator').show();

    var Veiculo = new Object();
    //----------------------------------    
    Veiculo.id = $('input#idveiculo').attr('value');    
    Veiculo.marca = $('input#marca').val();
    Veiculo.modelo = $('input#modelo').val();
    Veiculo.ano = $('input#ano').val();
    Veiculo.cor = $('input#cor').val();
    Veiculo.placa = $('input#placa').val();
    Veiculo.km = $('input#km').val();

    var veiculoJson = JSON.stringify(Veiculo);

    $.post('Controller.php',
        {
            action: 'update_veiculo_data',
            veiculo: veiculoJson
        },
        function (data, textStatus) {
            getVeiculoList(element);
            $('#indicator').hide();
        },
        "json"
    );
}

function getEditFormVeiculo(element) {
    var
    form = '<div class="input-prepend">';
    form += '<span class="add-on"><i class="icon-user icon-black"></i> ID</span>';
    form += '<input type="text" id="idveiculo" name="idveiculo" value="" class="input-xlarge" />';
    form += '</div><br/><br/>';

    form += '<div class="input-prepend">';
    form += '<span class="add-on"><i class="icon-user icon-black"></i> Marca</span>';
    form += '<input type="text" id="marca" name="marca" value="" class="input-xlarge" />';
    form += '</div><br/><br/>';

    form += '<div class="input-prepend">';
    form += '<span class="add-on"><i class="icon-home icon-black"></i>Modelo</span>';
    form += '<input type="text" id="modelo" name="modelo" class="input-xlarge" />';
    form += '</div><br/><br/>';

    form += '<div class="input-prepend">';
    form += '<span class="add-on"><i class="icon-home icon-black"></i>Ano</span>';
    form += '<input type="text" id="ano" name="ano" class="input-xlarge"/>';
    form += '</div><br/><br/>';

    form += '<div class="input-prepend">';
    form += '<span class="add-on"><i class="icon-home icon-black"></i>Cor</span>';
    form += '<input type="text" id="cor" name="cor" class="input-xlarge"/>';
    form += '</div><br/><br/>';

    form += '<div class="input-prepend">';
    form += '<span class="add-on"><i class="icon-envelope icon-black"></i>Placa</span>';
    form += '<input type="text" id="placa" name="placa" value="" class="input-xlarge" />';
    form += '</div><br/><br/>';

    form += '<div class="input-prepend">';
    form += '<span class="add-on"><i class="icon-headphones icon-black"></i>KM</span>';
    form += '<input type="text" id="km" name="km" value="" class="input-xlarge" />';
    form += '</div><br/><br/>';

    form += '<div class="control-group">';
    form += '<div class="">';
    form += '<button type="button" id="save_veiculo" class="btn btn-primary"><i class="icon-ok icon-white"></i> Confirma</button>';
    form += '</div>';
    form += '</div>';

    $('div#content').html(form);
////////////////////////////////
    //preenche os valores
////////////////////////////////		

    $('#indicator').show();


    $.post('Controller.php',
        {
            action: 'get_veiculo',
            veiculo: element.id
        },
        function (data) {
            var data = data[0];
            $('input#idveiculo').attr('value', data.id);
            $('input#marca').attr('value', data.marca);
            $('input#modelo').attr('value', data.modelo);
            $('input#ano').attr('value', data.ano);
            $('input#cor').attr('value', data.cor);
            $('input#placa').attr('value', data.placa);
            $('input#km').attr('value', data.km);
        },
        "json"
    );
    $('#indicator').hide();
}

////// ORCAMENTO   //////////////////////////////////////////////////////////////////
////// ORCAMENTO   //////////////////////////////////////////////////////////////////
////// ORCAMENTO   //////////////////////////////////////////////////////////////////
////// ORCAMENTO   //////////////////////////////////////////////////////////////////

function getOrcamentoList(element) {

    $('#indicator').show();

    $.post('Controller.php',
        {
            action: 'get_orcamentos'
        },
        function (data, textStatus) {
            renderOrcamentoList(data);
            $('#indicator').hide();
        },
        "json"
    );
}

function renderOrcamentoList(jsonData) {
    var table = '<a href="javascript:void(0);" id="create_orcamento_form" class="add_button btn "><i class="icon-plus-sign icon-blck"></i> Novo Orcamento </a></br>';
    table += '<table width="600" cellpadding="5" class="table table-hover table-bordered"><thead><tr><th scope="col">ID</th><th scope="col">Atendente</th><th scope="col">Pagamento</th><th scope="col">Total itens</th><th scope="col">Valor Total (R$)</th><th scope="col" colspan="2" >Ações</th></tr></thead><tbody>';
    var total = 0;
    $.each(jsonData, function (index, orcamento) {
        table += '<tr>';
        table += '<td class="edit" field="id"   cliente_id="' + orcamento.id + '">' + orcamento.id + '</td>';
        table += '<td class="edit" field="atendente"   cliente_id="' + orcamento.id + '">' + orcamento.atendente + '</td>';
        table += '<td class="edit" field="sformapagamento"    cliente_id="' + orcamento.id + '">' + orcamento.sformapagamento + '</td>';
        table += '<td class="edit" field="totaitens" cliente_id="' + orcamento.id + '">' + orcamento.totaitens + '</td>';
        table += '<td class="edit" field="vltotal"     cliente_id="' + orcamento.id + '">' + orcamento.vltotal + '</td>';
        table += '<td><a href="javascript:void(0);" id="' + orcamento.id + '" orcamento_id="' + orcamento.id + '" class="edit_orcamento btn btn-info"><i class="icon-folder-open icon-white"></i></a> ';
        table += ' <a href="javascript:void(0);" id="' + orcamento.id + '" orcamento_id="' + orcamento.id + '" class="delete_orcamento btn btn-danger"><i class="icon-remove icon-white"></i></a></td>';
        table += '</tr>'
        total = index;
    });
    if (total != 0){
        table += '<tr><td colspan=9>Total Registros: ' + (total + 1) + '</td></tr>';
    }else{
        table += '<tr><td colspan=9>Total Registros: ' + (total) + '</td></tr>';        
    }
    table += '</tbody></table>';


    $('div#content').html(table);
}

function getAddFormOrcamento(element) {

    var
    form = '<div class="input-prepend">';
    form += '<span class="add-on"><i class="icon-user icon-black"></i>Atendente</span>';
    form += '<input type="text" id="atendente" name="atendente" value="" class="input-xlarge" />';
    form += '</div><br/><br/>';

    form += '<div class="input-prepend">';
    form += '<span class="add-on"><i class="icon-home icon-black"></i>Pagamento</span>';
    form += '<input type="text" id="sformapagamento" name="sformapagamento" class="input-xlarge" />';
    form += '</div><br/><br/>';

    table = '<table width="600" id="table_orc" cellpadding="5" class="table table-hover table-bordered"><thead><tr><th scope="col">ID</th><th scope="col">Descrição</th><th scope="col">Qtd. Itens</th><th scope="col">Valor Item (R$)</th><th scope="col">Desconto (%)</th><th scope="col">Total Item (R$)</th></tr></thead><tbody>';     
    table += '<tr>'; 

    table += '<td class="edit" field="iditem"    id="1">1</td>';
    table += '<td class="edit" field="descricao"><input type="edit" id="descricao_1" name="descricao_1"></td>';
    table += '<td class="edit" field="qtditem"><input type="edit" id="qtditem_1" name="qtditem_1"></td>';    
    table += '<td class="edit" field="valoritem" id="valoritem"><input type="edit" id="valoritem_1"  name="valoritem_1" data-format="R$ 0.0[,]00"></td>';
    table += '<td class="edit" field="desconto" id="desconto"><input type="edit" id="desconto_1" name="desconto_1"></td>';    
     //data-format="$ 0,0[.]00"
     //http://www.xsanisty.com/project/calx/initialize/
    table += '<td class="edit" field="vltotalitem" id="vltotalitem"><input type="edit" id="vltotalitem_1" name="vltotalitem_1" data-formula="(($qtditem_1*$valoritem_1)-($qtditem_1*$valoritem_1)*($desconto_1/100))"></td>';
    table += '<td><a href="javascript:void(0);" id="1" class="add_itemorcamento btn btn-info"><i class="icon-plus icon-white"></i></a> ';

    table += '</tr>';
    table += '</tbody></table>';

    form += table;

    form += '<div class="input-prepend">';
    form += '<span class="add-on"><i class="icon-home icon-black"></i>Total Itens</span>';
    form += '<input type="text" id="totaitens" name="totaitens" class="input-xlarge"/>';
    form += '</div><br/><br/>';

    form += '<div class="input-prepend">';
    form += '<span class="add-on"><i class="icon-home icon-black"></i>Valor Total</span>';
    form += '<input type="text" id="vltotal" name="vltotal" class="input-xlarge"/>';
    form += '</div><br/><br/>';

    form += '<div class="control-group">';
    form += '<div class="">';
    form += '<button type="button" id="add_orcamento" class="btn btn-primary"><i class="icon-ok icon-white"></i> Confirma</button>';
    form += '</div>';
    form += '</div>';

    $('div#content').html(form);
	// cria um novo registro e gera im ID para o orcamento e quando salvar usa o mesmo.
}

function addOrcamento(element) {

    $('#indicator').show();


    var Orcamento = new Object();
    Orcamento.atendente = $('input#atendente').val();
    Orcamento.sformapagamento = $('input#sformapagamento').val();
    Orcamento.totaitens = $('input#totaitens').val();
    Orcamento.vltotal = $('input#vltotal').val();
    //adicionar itens do orçamento para serem adicionados no banco.
    Orcamento.itens = $('#table_orc :input').serialize();

    var orcamentoJson = JSON.stringify(Orcamento);

    $.post('Controller.php',
        {
            action: 'add_orcamento',
            orcamento: orcamentoJson
        },
        function (data)
        {
            if (data == 0) {
                getOrcamentoList(element);
                $('#indicator').hide();
            } else {
                $('#' + data.campo).focus();
                alert('ERROR: '+data.msg_erro);
                $('#indicator').hide();
            }
        },
        "json"
    );
}

function saveOrcamento(element) {

    $('#indicator').show();

    var Orcamento = new Object();
    //----------------------------------    
    Orcamento.id = $('input#idorcamento').attr('value');    
    Orcamento.atendente = $('input#atendente').val();
    Orcamento.sformapagamento = $('input#sformapagamento').val();
    Orcamento.totaitens = $('input#totaitens').val();
    Orcamento.vltotal = $('input#vltotal').val();

    var orcamentoJson = JSON.stringify(Orcamento);

    $.post('Controller.php',
        {
            action: 'update_orcamento_data',
            orcamento: orcamentoJson
        },
        function (data, textStatus) {
            getOrcamentoList(element);
            $('#indicator').hide();
        },
        "json"
    );

    //salvar itens do orcamento feito.
    $('#table_orc tr').each(function(row, tr){
    TableData = TableData 
        + $(tr).find('td:eq(1)').text() + ' '  // Task No.
        + $(tr).find('td:eq(2)').text() + ' '  // Date
        + $(tr).find('td:eq(3)').text() + ' '  // Description
        + $(tr).find('td:eq(4)').text() + ' '  // Task
        + $(tr).find('td:eq(5)').text() + ' '  // Task
        + '\n';
        alert(TableData);
});
}

function getEditFormOrcamento(element) {
    var
    form = '<div class="input-prepend">';
    form += '<span class="add-on"><i class="icon-user icon-black"></i> ID</span>';
    form += '<input type="text" id="idorcamento" name="idorcamento" value="" class="input-xlarge" />';
    form += '</div><br/><br/>';

    form += '<div class="input-prepend">';
    form += '<span class="add-on"><i class="icon-user icon-black"></i>Atendente</span>';
    form += '<input type="text" id="atendente" name="atendente" value="" class="input-xlarge" />';
    form += '</div><br/><br/>';

    form += '<div class="input-prepend">';
    form += '<span class="add-on"><i class="icon-home icon-black"></i>Pagamento</span>';
    form += '<input type="text" id="sformapagamento" name="sformapagamento" class="input-xlarge" />';
    form += '</div><br/><br/>';

    table = '<table width="600" id="table_orc" cellpadding="5" class="table table-hover table-bordered"><thead><tr><th scope="col">ID</th><th scope="col">Descrição</th><th scope="col">Qtd. Itens</th><th scope="col">Valor Item (R$)</th><th scope="col">Desconto (%)</th><th scope="col">Total Item (R$)</th></tr></thead><tbody>';     
    table += '<tr>'; 
    table += '</tr>';
    table += '</tbody></table>';

    form += table;

    form += '<div class="input-prepend">';
    form += '<span class="add-on"><i class="icon-home icon-black"></i>Total Itens</span>';
    form += '<input type="text" id="totaitens" name="totaitens" class="input-xlarge"/>';
    form += '</div><br/><br/>';

    form += '<div class="input-prepend">';
    form += '<span class="add-on"><i class="icon-home icon-black"></i>Valor Total</span>';
    form += '<input type="text" id="vltotal" name="vltotal" class="input-xlarge"/>';
    form += '</div><br/><br/>';

    form += '<div class="control-group">';
    form += '<div class="">';
    form += '<button type="button" id="save_orcamento" class="btn btn-primary"><i class="icon-ok icon-white"></i> Confirma</button>';
    form += '</div>';
    form += '</div>';

    $('div#content').html(form);
////////////////////////////////
    //preenche os valores
////////////////////////////////        

    $('#indicator').show();

// dados orçamento
    $.post('Controller.php',
        {
            action: 'get_orcamento',
            orcamento: element.id
        },
        function (data) {
            var data = data[0];
            $('input#idorcamento').attr('value', data.id);
            $('input#atendente').attr('value', data.atendente);
            $('input#sformapagamento').attr('value', data.sformapagamento);
            $('input#totaitens').attr('value', data.totaitens);
            $('input#vltotal').attr('value', data.vltotal);
        },
        "json"
    );

// dados dos itens do orçamento
    $.post('Controller.php',
        {
            action: 'get_itens_orcamento',
            orcamento: element.id
        },
        function (data) {
            //var data = data[0];
            // criar loop mara montar itens para a tabela pois pode retornar várias linhas.
            //$('input#idorcamento').attr('value', data.id);
            renderItensOrcamentoList(data);
        },
        "json"
    );


    $('#indicator').hide();
}


function renderItensOrcamentoList(jsonData) {
    var table = '';
    
    table = '<tr>';     
    $.each(jsonData, function (index, orcamento) {
        table += '<td class="edit" field="iditem"    id="'+index+'">'+index+'</td>';
        table += '<td class="edit" field="descricao"><input type="edit" id="descricao_'+index+'" value="'+orcamento.descricao+'"/></td>';
        table += '<td class="edit" field="qtditem"><input type="edit" id="qtditem_'+index+'" value="'+orcamento.qtditem+'"></td>';    
        table += '<td class="edit" field="valoritem" id="valoritem"><input type="edit" id="valoritem_'+index+'" data-format="R$ 0.0[,]00" value="'+orcamento.valoritem+'"/></td>';
        table += '<td class="edit" field="desconto" id="desconto"><input type="edit" id="desconto_'+index+'" name="desconto_'+index+'" value="'+orcamento.desconto+'"></td>';    
        table += '<td class="edit" field="vltotalitem" id="vltotalitem"><input type="edit" id="vltotalitem_'+index+'" name="vltotalitem_'+index+'" data-formula="(($qtditem_'+index+'*$valoritem_'+index+')-($qtditem_'+index+'*$valoritem_'+index+')*($desconto_'+index+'/100))"></td>';
        table += '<td><a href="javascript:void(0);" id="'+(orcamento.id+1)+'" class="add_itemorcamento btn btn-info"><i class="icon-plus icon-white"></i></a> ';
        table += '</tr>';
    });
    $('#table_orc').append(table); 
    alert('Valor intem com PAU!!!!!!');
    //$('#table_orc').calx();        
}


function AddNewLineItemOrcamento(element){
    $('a.add_itemorcamento').hide();
    var novo = parseInt(element.id)+1;

    table = '<tr>'; 
    table += '<td class="edit" field="iditem"    id="'+novo+'">'+novo+'</td>';
    table += '<td class="edit" field="descricao"><input type="edit" id="descricao_'+novo+'" name="descricao_'+novo+'"></td>';
    table += '<td class="edit" field="qtditem"><input type="edit" id="qtditem_'+novo+'" name="qtditem_'+novo+'"></td>';    
    table += '<td class="edit" field="valoritem" id="valoritem"><input type="edit" id="valoritem_'+novo+'" name="valoritem_'+novo+'" data-format="R$ 0.0[,]00"></td>';
    table += '<td class="edit" field="desconto" id="descitem"><input type="edit" id="desconto_'+novo+'" name="desconto_'+novo+'"></td>';    
     //http://www.xsanisty.com/project/calx/initialize/
    table += '<td class="edit" field="vltotalitem" id="vltotalitem"><input type="edit" id="vltotalitem_'+novo+'" name="vltotalitem_'+novo+'" data-formula="(($qtditem_'+novo+'*$valoritem_'+novo+')-($qtditem_'+novo+'*$valoritem_'+novo+')*($desconto_'+novo+'/100))"></td>';
    table += '<td><a href="javascript:void(0);" id="'+novo+'" class="add_itemorcamento btn btn-info"><i class="icon-plus icon-white"></i></a> ';
    table += '</tr>';

    $('#table_orc').append(table);    
}

function AtualizaValoresOrcamento(){
    $('#totaitens').val(SomaTotalQtdItens);    
    $('#vltotal').val(SomaValorTotalItens);
}

function SomaTotalQtdItens(){
    var qtd = 0;

    $('[id*="qtditem_"]').each(function () {
        qtd += parseInt($(this).val());
    });
    return qtd;
}

function SomaValorTotalItens(){
    var qtd = 0;

    $('[name*="vltotalitem_"]').each(function () {
        qtd += parseInt($(this).val());
    });
    return qtd;
}



