var LuisAPI = {
    __criar_modal:function(options)
    {
        var settings = $.extend({},{
            tamanho:''
        },options);
        
        var rnd = SIGX.gerar_codigo({tamanho:20});
        var content = '<div class="modal zoom" id="modal-'+rnd+'" tabindex="-1" role="dialog" aria-labelledby="m_'+rnd+'_lbl" aria-hidden="true">';
        content += '<div class="modal-dialog';
        if(settings.tamanho!='')
            content+= ' modal-'+settings.tamanho;
        content += '" role="document">';
        content += '<div class="modal-content">';
        content += '<div class="modal-header">';
        content += '<h5 class="modal-title" id="m_'+rnd+'_lbl"></h5>';
        content += '<button type="button" class="close" data-dismiss="modal" aria-label="Fechar">';
        content += '<span aria-hidden="true">&times;</span>';
        content += '</button>';
        content += '</div>';
        content += '<div class="modal-body">';
        content += '</div>';
        content += '<div class="modal-footer">';
        content += '</div>';
        content += '</div>';
        content += '</div>';
        content += '</div>';
        
        var mdl = $(content);
        if($('.modal').length==0) $('body').prepend(mdl);
        else mdl.insertAfter($('.modal').last());
        return mdl;
    },
    gerar_codigo:function(options)
    {
        var settings = $.extend({},{
            caracteres:'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789',
            tamanho:20
        },options);
        
        var saida = '';
        for(var i=0;i<settings.tamanho;i++)
            saida+=settings.caracteres[Math.floor(Math.random()*settings.caracteres.length)];
        return saida;
    },
    pergunta:function(options){
        var settings = $.extend({},{
            onhidden:function(){}
        },options);
        
        var mdl = LuisAPI.__criar_modal();
        $.each(settings.botoes,function(i,v){
            var btn = $('<button type="button" data-dismiss="modal" class="btn btn-outline-info">'+v.label+'</button>');
            btn.click(function(){
                v.acao();
            });
            mdl.find('.modal-footer').append(btn);
        });
        mdl.find('.modal-title').html(settings.titulo);
        mdl.find('.modal-body').html('<p class="text-center">'+settings.mensagem+'</p>');
        mdl.on('hidden.bs.modal',function(){
            mdl.remove();
            settings.onhidden();
        }).modal('show');
    },
    mensagem:function(options)
    {
        var settings = $.extend({},{
            onhidden:function(){}
        },options);

        var mdl = LuisAPI.__criar_modal();
        var btn = $('<button type="button" data-dismiss="modal" class="btn btn-outline-info">OK</button>');
        mdl.find('.modal-footer').append(btn);
        mdl.find('.modal-title').html(settings.titulo);
        mdl.find('.modal-body').html('<p class="text-center">'+settings.mensagem+'</p>');
        mdl.on('hidden.bs.modal',function(){
            mdl.remove();
            settings.onhidden();
        }).modal('show');
    }
}