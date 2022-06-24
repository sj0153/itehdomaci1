function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
}
function openNav() {
    document.getElementById("mySidenav").style.width = "250px";
}
$('#obrisi').click(function () {
    const checked = $('input[name=checked-donut]:checked');

    request = $.ajax({
        url: 'operations/delete.php',
        type: 'post',
        data: { 'id': checked.val() }
    });

    request.done(function (response, textStatus, jqXHR) {
        if (response === 'Success') {
            checked.closest('tr').remove();
            alert('Medij je obrisan');

        }
        else {
            alert('Medij nije obrisan');
        }
        console.log(response);
    });

    request.fail(function (jqXHR, textStatus, errorThrown) {
        console.error('The following error occurred: ' + textStatus, errorThrown);
    });


});

$('#prikazi').click(function () {
    $('#tabela').toggle();
});

$('#btnAdd').submit(function () {
    $('#id01').modal('toggle');
    return false;
});

$('#dodajForm').submit(function () {
    event.preventDefault();
    const $form = $(this);
    const $inputs = $form.find('input, select, button, textarea');
    const serializedData = $form.serialize(); 
    $inputs.prop('disabled', true);

    request = $.ajax({
        url: 'operations/add.php',
        type: 'post',
        data: serializedData
    });

    request.done(function (response, textStatus, jqXHR) {
        if (response === 'Success') {
            alert('Medij je dodat');
            location.reload(true);
        }
        else console.log('Sir nije dodat ' + response);
        console.log(response);
    });

    request.fail(function (jqXHR, textStatus, errorThrown) {
        console.error('The following error occurred: ' + textStatus, errorThrown);
    });
});

$('#btnChange').submit(function () {
    $('#myModal').modal('toggle');
    return false;
});

$('#link-izmeni').click(function () {
    const checked = $('input[name=checked-donut]:checked');

    request = $.ajax({
        url: 'operations/get.php',
        type: 'post',
        data: { 'id': checked.val() },
        dataType: 'json'
    });

    request.done(function (response, textStatus, jqXHR) {
        $('#nazivMed').val(response[0]['naziv']);
        $('#zemljaMed').val(response[0]['zemlja'].trim());       
        $('#zemljaMed').val(response[0]['naziv'].trim());        
        $('#karakterMed').val(response[0]['karakter_medija'].trim());      
        $('#godOsnMed').val(response[0]['god_osnivanja'].trim());
        $('#id').val(checked.val());
    });
    request.fail(function (jqXHR, textStatus, errorThrown) {
        console.error('The following error occurred: ' + textStatus, errorThrown);
    });

});

$('#Izmeni').submit(function () {
    event.preventDefault();
    const $form = $(this);
    const $inputs = $form.find('input, select, button, textarea');
    const serializedData = $form.serialize();
    console.log(serializedData);
    $inputs.prop('disabled', true);

    request = $.ajax({
        url: 'operations/update.php',
        type: 'post',
        data: serializedData
    });

    request.done(function (response, textStatus, jqXHR) {

        if (response === 'Success') {
            alert('Medij je izmenjen');
            console.log('Medij je izmenjen');
            location.reload(true);            
        }
        else console.log('Medij nije izmenjen ' + response);
        console.log(response);
    });
    request.fail(function (jqXHR, textStatus, errorThrown) {
        console.error('The following error occurred: ' + textStatus, errorThrown);
    });
});

function pretraga() {

    var input, filter, table, tr, i, td1, td2, td3, td4, td5, txtValue1, txtValue2, txtValue3, txtValue4, txtValue5;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("tabela");
    tr = table.getElementsByTagName("tr");

    for (i = 0; i < tr.length; i++) {
        td1 = tr[i].getElementsByTagName("td")[1];
        td2 = tr[i].getElementsByTagName("td")[2];
        td3 = tr[i].getElementsByTagName("td")[3];
        td4 = tr[i].getElementsByTagName("td")[4];
        td5 = tr[i].getElementsByTagName("td")[5];

        if (td1 || td2 || td3 || td4 || td5) {
            txtValue1 = td1.textContent || td1.innerText;
            txtValue2 = td2.textContent || td2.innerText;
            txtValue3 = td3.textContent || td3.innerText;
            txtValue4 = td4.textContent || td4.innerText;
            txtValue5 = td5.textContent || td5.innerText;

            if (txtValue1.toUpperCase().indexOf(filter) > -1 || txtValue2.toUpperCase().indexOf(filter) > -1 ||
                txtValue3.toUpperCase().indexOf(filter) > -1 || txtValue4.toUpperCase().indexOf(filter) > -1 || txtValue5.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}