$(document).on("click" , "#form-edit" ,function(e)
{
         e.preventDefault();
            var name  = $(this).data("name");
            var active  = $(this).data("active");
            var id  = $(this).data("id");
            console.log(name);
            document.getElementById("nameUpdate").value = name;
            document.getElementById("active").value = active;
            document.getElementById("id").value = id;
    
});
$(document).ready(function($)
{
        var table = $('.data-table-category').DataTable(
        {
            processing: true,
            serverSide: true,
            paging: false,
            ordering: false,
            searching: false,
            info: false,
            ajax:
            {
                    url: "category",
                            data: function (d) {
                                // d.type_order = $('#type_order').val(),
                                // d.search = $('#search').val()
                                // d.status = $('#status').val()

                            }
            },
            columns: [
            {data: 'name', name: 'name'},
            {data: 'active', name: 'active'},    
            {data: 'create', name: 'create'},
            {data: 'action', name: 'action'},]     
    

        });
    $('#SubmitFormCategory').on('submit',function(e)
    {      
    
            e.preventDefault();
            let formData = new FormData($('#SubmitFormCategory')[0]);
            $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }});
            $.ajax(
            {
                    type:"POST",
                    url: "category",
                    data:formData,
                    contentType:false, // determint type object 
                    processData: false,  // processing on response 
                    success:function(response)
                    {
                    $('#successMsg').show();
                    console.log(response);
                    var btn_close = document.getElementById('close');  
                    btn_close.click();
                    $('.data-table-category').DataTable(); // Initialize DataTable 
                $('.data-table-category').DataTable().draw(); // Call draw() after initialization
                    },
                
                    error: function(response) 
                    {
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
    $(".data-table-category").on('click', '.deleteRecord[data-id]', function (e)
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
                    url: "delete/"+id,
                    type: 'DELETE',
                    data: 
                    {
                        "id": id,
                        "_token": token,
                    },
                    success: function ()
                    {
                        console.log("it Works");
                        $('.data-table-category').DataTable().ajax.reload();
                    }
                    });

                }
                });

                
                });

        
        });

        $('#SubmitFormUpdateCategory').on('submit',function(e)
      {      

            e.preventDefault();
            let formData = new FormData($('#SubmitFormUpdateCategory')[0]);
            $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }});
            $.ajax(
            {
                    type:"POST",
                    url: "/category/update",
                    data:formData,
                    contentType:false, // determint type object 
                    processData: false,  // processing on response 
                    success:function(response)
                    {
                    $('#successMsg').show();
                    console.log(response);
                    var btn_close = document.getElementById('close_update_form');  
                    btn_close.click();
                    $('.data-table-category').DataTable(); // Initialize DataTable 
                    $('.data-table-category').DataTable().draw(); // Call draw() after initialization
                    },
                
                    error: function(response) 
                    {
                        console.log(response);
                        nameError.textContent =   response.responseJSON.name;  
                        console.log(response.responseJSON.name);
                            if( response.responseJSON.name)
                            {nameError.hidden = false;}else
                            {nameError.hidden = true;}
    
                        var activeError = document.getElementById('activeError');
                        activeError.textContent =   response.responseJSON.active;  
                        console.log(response.responseJSON.active);
                            if( response.responseJSON.active)
                            {activeError.hidden = false;}else
                            {activeError.hidden = true;}
    
                            
                    },
            });


});

});


        
