$(document).ready(function(){
        
    var body = $(document.body),
        filer_default_opts = {
            changeInput2: '<div class="jFiler-input-dragDrop"><div class="jFiler-input-inner"><div class="jFiler-input-icon"><i class="icon-jfi-cloud-up-o"></i></div><div class="jFiler-input-text"><h3>Drag&Drop files here</h3> <span style="display:inline-block; margin: 15px 0">or</span></div><a class="jFiler-input-choose-btn btn-custom blue-light">Browse Files</a></div></div>',
            templates: {
                box: '<ul class="jFiler-items-list jFiler-items-grid"></ul>',
                item: '<li class="jFiler-item" style="width:24%">\
                            <div class="jFiler-item-container">\
                                <div class="jFiler-item-inner">\
                                    <div class="jFiler-item-thumb">\
                                        <div class="jFiler-item-status"></div>\
                                        <div class="jFiler-item-thumb-overlay">\
    										<div class="jFiler-item-info">\
    											<div style="display:table-cell;vertical-align: middle;">\
    												<span class="jFiler-item-title"><b title="{{fi-name}}">{{fi-name}}</b></span>\
    												<span class="jFiler-item-others">{{fi-size2}}$%$</span>\
    											</div>\
    										</div>\
    									</div>\
                                        {{fi-image}}\
                                    </div>\
                                    <div class="jFiler-item-assets jFiler-row">\
                                        <ul class="list-inline pull-left">\
                                            <li>{{fi-progressBar}}<input type="text" name="image_name[]"  class="form-control" placeholder="Image name"> <input type="number" name="image_position[]"  class="form-control" placeholder="Pozycja" ></li>\
                                        </ul>\
                                        <ul class="list-inline pull-right">\
                                            <li><a class="icon-jfi-trash jFiler-item-trash-action"></a></li>\
                                        </ul>\
                                    </div>\
                                </div>\
                            </div>\
                        </li>',
                itemAppend: '<li class="jFiler-item" style="width:24%">\
                                <div class="jFiler-item-container">\
                                    <div class="jFiler-item-inner">\
                                        <div class="jFiler-item-thumb">\
                                            <div class="jFiler-item-status"></div>\
                                            <div class="jFiler-item-thumb-overlay">\
        										<div class="jFiler-item-info">\
        											<div style="display:table-cell;vertical-align: middle;">\
        												<span class="jFiler-item-title"><b title="{{fi-name}}">{{fi-name}}</b></span>\
        												<span class="jFiler-item-others">{{fi-size2}}&&&</span>\
        											</div>\
        										</div>\
        									</div>\
                                            {{fi-image}}\
                                        </div>\
                                        <div class="jFiler-item-assets jFiler-row">\
                                            <ul class="list-inline pull-left">\
                                                <li><input type="text" name="image_name[]"  class="form-control" placeholder="Image name" value="{{fi-file_title}}"> <input type="number" name="image_position[]"  class="form-control" placeholder="Pozycja" value="{{fi-file_position}}" ></li>\
                                            </ul>\
                                            <ul class="list-inline pull-right">\
                                                <li> <a class="icon-jfi-trash jFiler-item-trash-action"></a></li>\
                                            </ul>\
                                        </div>\
                                    </div>\
                                </div>\
                            </li>',
                progressBar: '<div class="bar"></div>',
                itemAppendToEnd: false,
                removeConfirmation: true,
                _selectors: {
                    list: '.jFiler-items-list',
                    item: '.jFiler-item',
                    progressBar: '.bar',
                    remove: '.jFiler-item-trash-action'
                }
            },
            dragDrop: {},
            /*uploadFile: {
                url: "./php/upload.php",
                data: {},
                type: 'POST',
                enctype: 'multipart/form-data',
                beforeSend: function(){},
                success: function(data, el){
                    var parent = el.find(".jFiler-jProgressBar").parent();
                    el.find(".jFiler-jProgressBar").fadeOut("slow", function(){
                        $("<div class=\"jFiler-item-others text-success\"><i class=\"icon-jfi-check-circle\"></i> Success</div>").hide().appendTo(parent).fadeIn("slow");
                    });

                    console.log(data);
                },
                error: function(el){
                    var parent = el.find(".jFiler-jProgressBar").parent();
                    el.find(".jFiler-jProgressBar").fadeOut("slow", function(){
                        $("<div class=\"jFiler-item-others text-error\"><i class=\"icon-jfi-minus-circle\"></i> Error</div>").hide().appendTo(parent).fadeIn("slow");
                    });
                },
                statusCode: null,
                onProgress: null,
                onComplete: null
            }*/
        };


    //Run PrettyPrint
    prettyPrint();

    //Pre Collapse
    $('.pre-collapse').on("click", function(e){
        var title = ["<i class=\"fa fa-code pull-left\"></i> + Show the source code", "<i class=\"fa fa-code pull-left\"></i> - Hide the source code"],
            $button = $(this),
            $parent = $(this).closest('.pre-box'),
            $pre = $parent.find('pre'),
            isCollapsed = !$pre.is(':visible');

        if(isCollapsed){
            $pre.slideDown(200);
            $button.html(title[1]);
        }else{
            $pre.slideUp(200);
            $button.html(title[0]);
        }
    });

/*$('#image-uploader').filer({
        templates: filer_default_opts.templates,
        //uploadFile: filer_default_opts.uploadFile,
        //limit: 5,
        maxSize: 50,
        //extensions: ['jpg', 'jpeg', 'png', 'gif','info'],
        addMore: true,
        showThumbs: true,
        files: [
            {
                name: "oko",
                file_title: "tytuł zdjęcia",
                file_position: 2,
                size: 5453,
                type: "image/jpg",
                file: "http://dummyimage.com/720x480/f9f9f9/191a1a.jpg"
            },
            {
                name: "appended_file_2.jpg",
                file_title: "tytuł zdjęcia2",
                file_position: 1,
                size: 9453,
                type: "image/jpg",
                file: "http://dummyimage.com/640x480/f9f9f9/191a1a.jpg"
            }
        ]
        
        
    });*/

    //Apply jQuery.filer
    /*$('#demo-fileInput-1').filer({
        limit: null,
        maxSize: null,
        extensions: null,
        changeInput: filer_default_opts.changeInput2,
        showThumbs: true,
        appendTo: '.demo-fileInput-thumbs',
        theme: "dragdropbox",
        templates: {
            box: '<ul class="jFiler-items-list jFiler-items-grid"></ul>',
            item: '<li class="jFiler-item">\
                        <div class="jFiler-item-container">\
                            <div class="jFiler-item-inner">\
                                <div class="jFiler-item-thumb">\
                                    <div class="jFiler-item-status"></div>\
                                    <div class="jFiler-item-thumb-overlay">\
										<div class="jFiler-item-info">\
											<div style="display:table-cell;vertical-align: middle;">\
												<span class="jFiler-item-title"><b title="{{fi-name}}">{{fi-name}}</b></span>\
												<span class="jFiler-item-others">{{fi-size2}}</span>\
											</div>\
										</div>\
									</div>\
                                    {{fi-image}}\
                                </div>\
                                <div class="jFiler-item-assets jFiler-row">\
                                    <ul class="list-inline pull-left">\
                                        <li>{{fi-progressBar}}</li>\
                                    </ul>\
                                    <ul class="list-inline pull-right">\
                                        <li><a class="icon-jfi-trash jFiler-item-trash-action"></a></li>\
                                    </ul>\
                                </div>\
                            </div>\
                        </div>\
                    </li>',
            progressBar: '<div class="bar"></div>',
            itemAppendToEnd: false,
            removeConfirmation: false,
            _selectors: {
                list: '.jFiler-items-list',
                item: '.jFiler-item',
                progressBar: '.bar',
                remove: '.jFiler-item-trash-action',
            }
        },
        dragDrop: filer_default_opts.dragDrop,
        uploadFile: filer_default_opts.uploadFile
    });

    $('#demo-fileInput-2').filer();

    $('#demo-fileInput-3').filer({
        limit: 3,
        maxSize: 3,
        extensions: ['jpg', 'jpeg', 'png', 'gif'],
        changeInput: true,
        showThumbs: true
    });

    $('#demo-fileInput-4').filer({
        changeInput: '<div class="jFiler-input-dragDrop"><div class="jFiler-input-inner"><div class="jFiler-input-icon"><i class="icon-jfi-folder"></i></div><div class="jFiler-input-text"><h3>Click on this box</h3> <span style="display:inline-block; margin: 15px 0">or</span></div><a class="jFiler-input-choose-btn btn-custom blue-light">Browse Files</a></div></div>',
        showThumbs: true,
        theme: "dragdropbox",
        templates: filer_default_opts.templates
    });

    $('#demo-fileInput-5').filer({
        limit: 3,
        maxSize: 3,
        extensions: ['jpg', 'jpeg', 'png', 'gif'],
        changeInput: true,
        showThumbs: true,
        addMore: true
    });

    $('#demo-fileInput-6').filer({
        changeInput: filer_default_opts.changeInput2,
        showThumbs: true,
        theme: "dragdropbox",

        templates: filer_default_opts.templates,
        dragDrop: filer_default_opts.dragDrop,
        uploadFile: filer_default_opts.uploadFile
    });

    $('#demo-fileInput-7').filer({
        showThumbs: true,
        templates: filer_default_opts.templates,
        dragDrop: filer_default_opts.dragDrop,
        uploadFile: filer_default_opts.uploadFile
    });)*/

    /*$('#demo-fileInput-8').filer({
        templates: filer_default_opts.templates,
        //uploadFile: filer_default_opts.uploadFile,
        //limit: 5,
        maxSize: 50,
        //extensions: ['jpg', 'jpeg', 'png', 'gif','info'],
        addMore: true,
        showThumbs: true,
        files: [
            {
                name: "oko",
                file_title: "tytuł zdjęcia",
                file_position: 2,
                size: 5453,
                type: "image/jpg",
                file: "http://dummyimage.com/720x480/f9f9f9/191a1a.jpg"
            },
            {
                name: "appended_file_2.jpg",
                file_title: "tytuł zdjęcia2",
                file_position: 1,
                size: 9453,
                type: "image/jpg",
                file: "http://dummyimage.com/640x480/f9f9f9/191a1a.jpg"
            }
        ]
        
        
    });*/


});
