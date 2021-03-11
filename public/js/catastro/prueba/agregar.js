
'use strict';
$(document).ready(function () {

// $('#btnGuardar').on('click',function(e){
//      event.preventDefault(e);
//     var form = $(this).parents('form');
//     swal({
//         title: "Are you sure?",
//         text: "You will not be able to recover this imaginary file!",
//         type: "warning",
//         showCancelButton: true,
//         confirmButtonColor: "#DD6B55",
//         confirmButtonText: "Yes, delete it!",
//         closeOnConfirm: false
//     }, function(isConfirm){
//         if (isConfirm) form.submit();
//     });
// });
    // $('.btn-ok').on('click', function() {
    //     swal({
    //         title: "Good job!",
    //         text:"You clicked the button!",
    //         type:"warning"
    //         });
    // });

// $(".btn-ok").submit(function(event){
//     event.preventDefault();
//     Swal.fire({
//     title: '¿Seguro de enviar el formulario?',
//     type: 'warning',
//     showCancelButton: true,
//     confirmButtonText: 'Si',
//     cancelButtonText: "No",
//     confirmButtonColor: '#3085d6',
//     cancelButtonColor: '#d33',
//     }).then((result) => {
//         if (result.value) {
//             console.log('asd');
//             document.aportacion_form.submit();
//             window.location.href = "aportacion";
//         }
//         return false;
//     });
// });

    // $('.btn-ok').on('click', function(e) {
    //     event.preventDefault(e);
    //     swal({
    //         title: "Are you sure?",
    //         text: "You will not be able to recover this imaginary file!",
    //         type: "warning",
    //         showCancelButton: true,
    //         confirmButtonColor: "#DD6B55",
    //         confirmButtonText: "Yes, delete it!",
    //         closeOnConfirm: false
    //         }).then((result) => {
    //         if (result.value) {
    //             console.log('asd');
    //         }
    //         return false;
    //     });
    // });

// $(".btn-ok").submit(function (e) {
//     e.preventDefault();
//     swal({
//         title: $(this).data("swa-title"),
//         text: $(this).data("swa-text"),
//         type: "warning",
//         showCancelButton: true,
//         confirmButtonColor: "#cc3f44",
//         confirmButtonText: $(this).data("swa-btn-txt"),
//         closeOnConfirm: false,
//         html: false
//     }, function(){
//         $(".btn-ok").off("submit").submit();
//     });
// });

    $('.btn-ok').on('click', function(e) {
        event.preventDefault(e);
        swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this imaginary file!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    console.log('asd1');
                    swal("Poof! Your imaginary file has been deleted!", {
                        icon: "success",
                    }).then((willOk) => {
                        console.log('asd2');
                    });
                } else {
                    swal("Your imaginary file is safe!", {
                        icon: "error",
                    });
                }
            });
    });

    // $('.btn-ok').on('click', function(e) {
    //     event.preventDefault(e);
    //     swal({
    //         title: "Are you sure you want to reset your game?",
    //         text: "You will not be able to recover your game!",
    //         type:  "success",
    //         }).then((willOk) => {
    //             console.log('asd');
    //         });
    // });

});

        // const swalWithBootstrapButtons = Swal.mixin({
        //     customClass: {
        //         confirmButton: 'btn btn-success',
        //         cancelButton: 'btn btn-danger'
        //     },
        //     buttonsStyling: false,
        // })

        // swalWithBootstrapButtons.fire({
        //     title: 'Are you  sure?',
        //     text: "Check plz",
        //     type: 'warning',
        //     showCancelButton: true,
        //     confirmButtonText: 'OK',
        //     cancelButtonText: 'Cancel',
        //     reverseButtons: true
        // }).then((result) => {
        //     if (result.value) {
        //         swalWithBootstrapButtons.fire(
        //                 'Finished',
        //                 'Success',
        //                 'success',
        //             );
        //         $form.submit();
        //     } else if (
        //         result.dismiss === Swal.DismissReason.cancel
        //     ) {
        //         swalWithBootstrapButtons.fire(
        //             'Canceled',
        //             'Do corrections and then retry :)',
        //             'error'
        //         );
        //     }
        // });



// function confirmReset(e) {
// swal({
//         title: "Are you sure you want to reset your game?",   text: "You will not be able to recover your game!",
//         type: "warning",
//         showCancelButton: true,
//         confirmButtonColor: "#DD6B55",
//         confirmButtonText: "Yes, delete it!",
//         closeOnConfirm: false
//         }, function(){
//             swal({
//                 title: "Deleted!",
//                 text: "Your imaginary file has been deleted.",
//                 type: "success",
//                 timer: 3000
//             },
//             function(){
//                 window.location.href = "/";
//             })
//     });
// }
