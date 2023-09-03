$('.itemName').select2({
placeholder: 'Select an item',
ajax: {
    url: '/select2-autocomplete-ajax-device',
    dataType: 'json',
    delay: 250,
    processResults: function (data) {
    return {
        results:  $.map(data, function (item) {
            return {
            
                text: item.name,
                id: item.id
            }
        })
    };
    },
    // cache: true
}
});

$(document).on("click" , "#form-edit" ,function(e)
{
 e.preventDefault();
    var name  = $(this).data("name");
    var author  = $(this).data("author");
    var date  = $(this).data("date");
    var category  = $(this).data("category");
    var details  = $(this).data("details");
    var price  = $(this).data("price");
    var id  = $(this).data("id");
    console.log(details);
    document.getElementById("nameUpdate").value = name;
    document.getElementById("authorUpdate").value = author;
    document.getElementById("dateUpdate").value = date;
    document.getElementById("detailsUpdate").value = details;
    document.getElementById("priceUpdate").value = price;
    document.getElementById("id").value = id;

    var selectElement = document.getElementById("categoryUpdate");
     selectElement.value =category;
      

});
$(document).ready(function($)
{
var table = $('.data-table-books').DataTable(
{
    processing: true,
    serverSide: true,
    paging: false,
    ordering: false,
    searching: false,
    info: false,
    ajax:
    {
            url: "books",
                    data: function (d) {
                        d.category = $('#category').val()
                    }
    },
    columns: [
        {data: 'name', name: 'name'},
        {data: 'author', name: 'author'},
        {data: 'category_id', name: 'category'},
        {data: 'details', name: 'details'},    
        {data: 'price', name: 'price'},    
        {data: 'date_of_publication', name: 'date'},    
        {data: 'create', name: 'create'},
        {data: 'action', name: 'action'},]     


});
$('.itemName').change(function(event){
         table.draw();
   });

$('#SubmitFormBooks').on('submit',function(e)
{      

        e.preventDefault();
        let formData = new FormData($('#SubmitFormBooks')[0]);
        $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }});
        $.ajax(
        {
                type:"POST",
                url: "books",
                data:formData,
                contentType:false, // determint type object 
                processData: false,  // processing on response 
                success:function(response)
                {
                $('#successMsg').show();
                console.log(response);
                var btn_close = document.getElementById('close');  
                btn_close.click();
                $('.data-table-books').DataTable(); // Initialize DataTable 
                $('.data-table-books').DataTable().draw(); // Call draw() after initialization
                },
            
                error: function(response) 
                {

                    console.log(response);
                    var nameError = document.getElementById('nameError');
                    nameError.textContent =   response.responseJSON.errors.name;  
                    console.log(response.responseJSON.errors.name);
                        if( response.responseJSON.errors.name)
                        {
                            nameError.hidden = false;
                        }else
                        {
                            nameError.hidden = true;

                        }
                        var authorError = document.getElementById('authorError');
                        authorError.textContent =   response.responseJSON.errors.author;  
                        console.log(response.responseJSON.errors.author);
                        if( response.responseJSON.errors.author)
                        {
                            authorError.hidden = false;
                        }else
                        {
                            authorError.hidden = true;

                        }
                    console.log(response.responseJSON.errors.category_id);

                        var categoryError = document.getElementById('categoryError');
                        categoryError.textContent =   response.responseJSON.errors.category_id;  
                        console.log(response.responseJSON.errors.category_id);
                        if( response.responseJSON.errors.category_id)
                        {
                            categoryError.hidden = false;
                        }else
                        {
                            categoryError.hidden = true;

                        }
                        var detailsError = document.getElementById('detailsError');
                        detailsError.textContent =   response.responseJSON.errors.details;  
                        console.log(response.responseJSON.errors.details);
                        if( response.responseJSON.errors.details)
                        {
                            detailsError.hidden = false;
                        }else
                        {
                            detailsError.hidden = true;

                        }
                        var priceError = document.getElementById('priceError');
                        priceError.textContent =   response.responseJSON.errors.price;  
                        console.log(response.responseJSON.errors.price);
                        if( response.responseJSON.errors.price)
                        {
                            priceError.hidden = false;
                        }else
                        {
                            priceError.hidden = true;

                        }
                        var dateError = document.getElementById('dateError');
                        dateError.textContent =   response.responseJSON.errors.date;  
                        console.log(response.responseJSON.errors.date);
                        if( response.responseJSON.errors.date)
                        {
                            dateError.hidden = false;
                        }else
                        {
                            dateError.hidden = true;

                        }

                        var imageError = document.getElementById('imageError');
                        imageError.textContent =   response.responseJSON.errors.image;  
                        console.log(response.responseJSON.errors.image);
                            if( response.responseJSON.errors.image)
                            {
                                imageError.hidden = false;
                            }else
                            {
                                imageError.hidden = true;
    
                            }
                },
        });


});
$(".data-table-books").on('click', '.deleteRecord[data-id]', function (e)
 { 
            e.preventDefault();
        $('.show_confirm').click(function(event)
            {
        
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                })
                .then((willDelete) => 
            { 
                if (willDelete.isConfirmed)
                {
                var id = $(this).data("id");
                var token = $("meta[name='csrf-token']").attr("content");
        
                $.ajax(
                {
                url: "books/delete/"+id,
                type: 'DELETE',
                data: 
                {
                    "id": id,
                    "_token": token,
                },
                success: function ()
                {
                    console.log("it Works");
                    $('.data-table-books').DataTable().ajax.reload();
                }
                });

            }
            });

            
            });

    
    });

$('#SubmitFormBooksUpdate').on('submit',function(e)
 {      

    e.preventDefault();
    let formData = new FormData($('#SubmitFormBooksUpdate')[0]);
    $.ajaxSetup({
    headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }});
    $.ajax(
    {
            type:"POST",
            url: "/books/update",
            data:formData,
            contentType:false, // determint type object 
            processData: false,  // processing on response 
            success:function(response)
            {
            $('#successMsg').show();
            console.log(response);
            var btn_close = document.getElementById('close_form_update_book');  
            btn_close.click();
            $('.data-table-books').DataTable(); // Initialize DataTable 
            $('.data-table-books').DataTable().draw(); // Call draw() after initialization
            },
        
            error: function(response) 
                {

                    console.log(response);
                    var nameError = document.getElementById('nameError');
                    nameError.textContent =   response.responseJSON.errors.name;  
                    console.log(response.responseJSON.errors.name);
                        if( response.responseJSON.errors.name)
                        {
                            nameError.hidden = false;
                        }else
                        {
                            nameError.hidden = true;

                        }
                        var authorError = document.getElementById('authorError');
                        authorError.textContent =   response.responseJSON.errors.author;  
                        console.log(response.responseJSON.errors.author);
                        if( response.responseJSON.errors.author)
                        {
                            authorError.hidden = false;
                        }else
                        {
                            authorError.hidden = true;

                        }
                           console.log(response.responseJSON.errors.category_id);

                        var categoryError = document.getElementById('categoryError');
                        categoryError.textContent =   response.responseJSON.errors.category_id;  
                        console.log(response.responseJSON.errors.category_id);
                        if( response.responseJSON.errors.category_id)
                        {
                            categoryError.hidden = false;
                        }else
                        {
                            categoryError.hidden = true;

                        }
                        var detailsError = document.getElementById('detailsError');
                        detailsError.textContent =   response.responseJSON.errors.details;  
                        console.log(response.responseJSON.errors.details);
                        if( response.responseJSON.errors.details)
                        {
                            detailsError.hidden = false;
                        }else
                        {
                            detailsError.hidden = true;

                        }
                        var priceError = document.getElementById('priceError');
                        priceError.textContent =   response.responseJSON.errors.price;  
                        console.log(response.responseJSON.errors.price);
                        if( response.responseJSON.errors.price)
                        {
                            priceError.hidden = false;
                        }else
                        {
                            priceError.hidden = true;

                        }
                        var dateError = document.getElementById('dateError');
                        dateError.textContent =   response.responseJSON.errors.date;  
                        console.log(response.responseJSON.errors.date);
                        if( response.responseJSON.errors.date)
                        {
                            dateError.hidden = false;
                        }else
                        {
                            dateError.hidden = true;

                        }

                        var imageError = document.getElementById('imageError');
                        imageError.textContent =   response.responseJSON.errors.image;  
                        console.log(response.responseJSON.errors.image);
                            if( response.responseJSON.errors.image)
                            {
                                imageError.hidden = false;
                            }else
                            {
                                imageError.hidden = true;
    
                            }
                },
    });


});




});





 