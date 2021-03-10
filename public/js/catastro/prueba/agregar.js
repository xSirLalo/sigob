

// [ sweet-success ]
// $('.btn-ok').on('click', function(e) {
//     event.preventDefault(e);
//     swal({
//         title: "Are you sure you want to reset your game?",
//         text: "You will not be able to recover your game!",
//         type:  "success",
//         }).then((result) => {
//         if (result.value) {
//             console.log('asd');
//         }
//         return false;
//     });
// });
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

// $(".sweet-success").submit(function(event){
//     event.preventDefault();
//     Swal.fire({
//     title: '¿Seguro de enviar el formulario?',
//     type: 'warning',
//     showCancelButton: true,
//     confirmButtonText: 'Si',
//     cancelButtonText: "No",
//     confirmButtonColor: '#3085d6',
//     cancelButtonColor: '#d33',
    // }).then((result) => {
    //     if (result.value) {
    //         console.log('asd');
    //         document.aportacion_form.submit();
    //         window.location.href = "aportacion";
    //     }
    //     return false;
    // });
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
