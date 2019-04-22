// Ajax for upload image:
$(document).ready(function() {
    $('#form').on('submit', function(event) {
        event.preventDefault();
        var file_data = $('#file').prop('files')[0];
        var form_data = new FormData();
        form_data.append('file', file_data);
        var url = new URL(window.location.href);
        var direct =  url.searchParams.get('folder');
        var dir;
        if (direct)
            {
                dir = direct;
            }
        else
            {
                dir = 'compressed';
            }
        form_data.append('folder', dir);
        $.ajax({
            url: 'upload.php',
            dataType: 'text',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
            success: function(response) {
                console.log(response);
                $('.cont').html(response);

            }
        });
    });
});

// Ajax for delete images:
function remove(element,event) {
    event.preventDefault();
    var urlParams = new URLSearchParams(element.search);
    var path = urlParams.get('path');
    var url = new URL(window.location.href);
    var direct =  url.searchParams.get('folder');
    if (direct)
        {
            path = direct + path;
        }
    else
        {
            path = 'compressed' + path;
        }
    $.ajax({
        url:"delete.php",
        type:"POST",
        data: {path: path, folder:direct},
        success:function(response)
        {
                $('.cont').html(response);
        }
    })
};


//Ajax for rename
function form_rename(element, e) {
 e.preventDefault();
 var newname = element.children[0].value;
 var oldname = element.children[1].value;
    if (newname === "" || oldname === "" || newname === oldname )
    {
         element.children[0].classList.add("actived");
         // element.children[0].focus();
         return false;
    }

 element.children[0].classList.remove("actived");

    var url = new URL( window.location.href );
    var direct =  url.searchParams.get('folder');
    var dir;
        if (direct)
        {
            dir = direct ;
        }
        else
        {
            dir = 'compressed' ;
        }
 $.ajax({
     url:"rename.php",
     type:"POST",
     data: {oldname: oldname, newname: newname ,folder: dir },
     success:function(response){
         console.log(element);
         element.children[0].value = response;
         element.children[1].value = response;
         console.log(e);
         e.path.forEach(function(elem)
         {
             if (elem.className=='active')
             {
                 elem.children[4].children[0].href =  'delete.php?path=' + response;
             }
             if(elem.className == "card")
             {
                 elem.children[0].src = direct + response;
             }
         })
     }
 });
};


// Ajax vor window click
 var hiddenInput;
 window.onclick = function(e) {

     var path = e.path || e.composedPath && e.composedPath();
     e.path.forEach(function (elem)
     {
         if (elem.className == 'focus')
         {
             hiddenInput = elem.children[0].children[1].value;
             console.log(hiddenInput);
         }
     });
     var input = document.querySelectorAll(".myinput");
     input.forEach(function(elem) {
         elem.classList.remove("actived");
         if (!path.includes(elem))
         {
             if (elem.value == "")
             {
                 elem.value = hiddenInput;
             }
         }
     })
 };

