/**
 * webuploader图片上传
 */
$(function() {
  console.log('webuploader图片上传。。。');

  var webuploaderutil = {};
  // Web Uploader实例
  var uploader;

  var $list = $('#fileList'),
  // 优化retina, 在retina下这个值是2
  ratio = window.devicePixelRatio || 1,
  thumbnailWidth = 100 * ratio, thumbnailHeight = 100 * ratio,

  // 初始化Web Uploader
  uploader = WebUploader.create({
    // 自动上传。
    // auto : false,
    // 文件接收服务端。
    server : '{:url("upload/index/upload")}',
    // 选择文件的按钮。可选。
    // 内部根据当前运行是创建，可能是input元素，也可能是flash.
    pick : '#filePicker',
    // 只允许选择文件，可选。
    accept : {
      title : 'Images',
      extensions : 'gif,jpg,jpeg,bmp,png',
      mimeTypes : 'image/*'
    }
  });

  // 当有文件添加进来的时候
  uploader.on('fileQueued', function(file) {
     var $li = $('<div id="' + file.id + '" class="file-item thumbnail">'
        + '<img>' + '<div class="info">' + file.name + '</div>'
        + '</div>'), $img = $li.find('img');

     $list.append($li);

    // 创建缩略图
    uploader.makeThumb(file, function(error, src) {
      if (error) {
        $("#face_image").replaceWith('<span>不能预览</span>');
        $img.attr( 'src', src );
        return;
      }

      $img.attr( 'src', src );
      $("#face_image").attr('src', src);
    }, thumbnailWidth, thumbnailHeight);

  });

  // 文件上传过程中创建进度条实时显示。
  uploader.on('uploadProgress', function(file, percentage) {
    var $li = $( '#'+file.id ),
    $percent = $li.find('.progress span');

    // 避免重复创建
    if ( !$percent.length ) {
        $percent = $('<p class="progress"><span></span></p>')
                .appendTo( $li )
                .find('span');
    }

    $percent.css( 'width', percentage * 100 + '%' );
  });

  // 文件上传成功，给item添加成功class, 用样式标记上传成功。
  uploader.on('uploadSuccess', function(file, response) {
    $('#' + file.id).addClass('upload-state-done');

    //重新初始化
//    webuploaderutil.uploadPicByResp(uploadDiv, imgEle, success, error);
    console.log('response:', response);
  });

  // 文件上传失败，现实上传出错。
  uploader.on('uploadError', function(file) {
    var $li = $('#' + file.id), $error = $li.find('div.error');

    // 避免重复创建
    if (!$error.length) {
      $error = $('<div class="error"></div>').appendTo($li);
    }

    $error.text('上传失败');
  });

  // 完成上传完了，成功或者失败，先删除进度条。
  uploader.on('uploadComplete', function(file) {
    $('#' + file.id).find('.progress').remove();
  });
});