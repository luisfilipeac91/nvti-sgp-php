/*
*
* SIGX.mini.js versão 2.0
* Criado por Luis.Couto
* Contém chamadas para todas as interfaces e comunicações SIGX e suas aplicações
*
* Criado: 05/03/2020
* Proibida a cópia e/ou reprodução
*
* Favor não alterar seu conteúdo se não tiver conhecimento do mesmo
*
*/

"use strict";

var SIGX;
(function ($) {
    SIGX = 
    {
        /* GET/SET */
        get pagina()
        {
            var n = window.location.hash;
            if(n.indexOf('!')==1)
                n = n.substring(2,n.length);
            if(n.indexOf('/')>-1)
                n = n.substring(0,n.indexOf('/'));
            
            return n;
        },
        set pagina(n)
        {
            window.location.hash = '#!'+n;
            SIGX.exibir_painel({alias:n});
        },
        __create_modal:function(options)
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
            content += '<button type="button" class="btn btn-secondary" data-dismiss="modal">OK</button>';
            content += '</div>';
            content += '</div>';
            content += '</div>';
            content += '</div>';
            
            if($('.modal').length==0) $('body').prepend(content);
            else $(content).insertAfter($('.modal').last());
            return 'modal-'+rnd;
        },
        pergunta:function(options)
        {
            var settings = $.extend({},{
                icone:'',
                titulo:'Pergunta',
                mensagem:'Descritivo',
                onload:function(){},
                onshown:function(){},
                onhidden:function(){},
                botoes:[
                    {
                        label:'Sim',
                        icone:'fas fa-check fa-fw',
                        class:'btn btn-primary',
                        acao:function(){}
                    },
                    {
                        label:'Não',
                        icone:'fas fa-times fa-fw',
                        class:'btn btn-secondary',
                        acao:function(){}
                    }
                ]
            },options);
            var mId = SIGX.__create_modal();
            $('#'+mId).addClass('md-mensagem');
            if(settings.icone!='')
                $('#'+mId).find('.modal-header').prepend('<span class="h-icone"><i class="'+settings.icone+'"></i></span>');
            $('#'+mId).find('.modal-title').html(settings.titulo);
            $('#'+mId).find('.modal-body').html(settings.mensagem);
            $('#'+mId).find('.modal-footer').html('');
            $.each(settings.botoes,function(i,v){ 
                var content = '<button type="button" class="';
                if(v.class==undefined || v.class=='')
                    v.class = 'btn btn-secondary';
                content+= v.class;
                content+= '" data-dismiss="modal" data-label="'+v.label+'">';
                if(v.icone!='')
                content+= '<i class="'+v.icone+'"></i> ';
                content+= v.label;
                content+= '</button>';
                var $content = $(content);
                $content.on('click',function(){
                    if($.isFunction(v.acao)) v.acao();
                });
                $('#'+mId).find('.modal-footer').append($content);
            });
            settings.onload($('#'+mId));
            $('#'+mId).on('hidden.bs.modal',function(){
                $(this).remove();
                settings.onhidden();
            }).on('shown.bs.modal',function(){
                $.each(settings.botoes,function(i,v){
                    if(v.focus!==undefined && v.focus==true)
                    $('#'+mId+' .modal-footer button[data-label="'+v.label+'"]').focus();
                });
                settings.onshown({
                    modal_id:mId
                });
            }).modal({backdrop: 'static', keyboard: false});
            $('#'+mId).modal('show');
        },
        mensagem:function(options)
        {
            var settings = $.extend({},{
				icone:'',
                titulo:'Título',
                mensagem:'Mensagem',
                tamanho:'',
				ondispose:function(){}
            },options);
            
            var mId = SIGX.__create_modal({
                tamanho:settings.tamanho
            });
            $('#'+mId).addClass('md-mensagem');
            
            if(settings.icone!='')
                $('#'+mId).find('.modal-header').prepend('<span class="h-icone"><i class="'+settings.icone+'"></i></span>');
            $('#'+mId).find('.modal-title').text(settings.titulo);
            $('#'+mId).find('.modal-body').html(settings.mensagem);
            $('#'+mId).find('.modal-footer').html('<button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-check fa-fw"></i> OK</button>');
            
            $('#'+mId).on('hidden.bs.modal',function(){
                $(this).remove();
				settings.ondispose();
            }).modal('show');
            
        },
        erro:function(options)
        {
            var settings = $.extend({},{
				icone:'fas fa-exclamation-circle',
                titulo:'Erro',
                mensagem:'Erro genérico',
                tamanho:'',
				ondispose:function(){}
            },options);
            SIGX.mensagem(settings);
        },
        toast:function(options) // Gera um toast informando uma mensagem
        {
            var settings = $.extend({},{
                titulo:'Mensagem',
                mensagem:'Mensagem genérica',
                timeout:3000
            },options);
            if($('#sigx000_toast_container').length==0)
            {
                var c1 = '<div id="sigx000_toast_container" class="toast-c" aria-live="polite" aria-atomic="true"></div>';
                $('body').prepend(c1);
            }
            var $tc = $('#sigx000_toast_container');
            var $toast = $('<div class="toast" data-delay="'+settings.timeout+'"><div class="toast-header"><strong class="mr-auto">'+settings.titulo+'</strong><button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Fechar"><span aria-hidden="true">&times;</span></button></div><div class="toast-body">'+settings.mensagem+'</div></div>');
            $toast.toast('show');
            $tc.append($toast);
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
        is_fullscreen:function()
        {
            return (document.fullscreenElement && document.fullscreenElement !== null) ||
            (document.webkitFullscreenElement && document.webkitFullscreenElement !== null) ||
            (document.mozFullScreenElement && document.mozFullScreenElement !== null) ||
            (document.msFullscreenElement && document.msFullscreenElement !== null);
        },
        fullscreen:function()
        {
            var docElm = document.documentElement;
            if(!SIGX.is_fullscreen())
            {
                if (docElm.requestFullscreen) 
                    docElm.requestFullscreen();
                else if (docElm.mozRequestFullScreen) 
                    docElm.mozRequestFullScreen();
                else if (docElm.webkitRequestFullScreen)
                    docElm.webkitRequestFullScreen();
                else if (docElm.msRequestFullscreen)
                    docElm.msRequestFullscreen();
                
                $('#sigx000_fllscrn_btn').html('<i class="fas fa-compress fa-fw"></i>');
            }
            else
            {
                if (document.exitFullscreen)
                    document.exitFullscreen();
                else if (document.webkitExitFullscreen)
                    document.webkitExitFullscreen();
                else if (document.mozCancelFullScreen)
                    document.mozCancelFullScreen();
                else if (document.msExitFullscreen)
                    document.msExitFullscreen();
                
                $('#sigx000_fllscrn_btn').html('<i class="fas fa-expand fa-fw"></i>');
            }
        },
        base64_decode:function(str)
        {
            return decodeURIComponent(escape(window.atob(str)));
        },
        n2l:function(n)
        {
            var l = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            return l[n];
        },
        replace_accents:function(strIn)
        {
            var strAccents = strIn.split('');
            var strAccentsOut = new Array();
            var strAccentsLen = strIn.length;
            var accents = 'ÀÁÂÃÄÅàáâãäåÒÓÔÕÕÖØòóôõöøÈÉÊËèéêëðÇçÐÌÍÎÏìíîïÙÚÛÜùúûüÑñŠšŸÿýŽž';
            var accentsOut = "AAAAAAaaaaaaOOOOOOOooooooEEEEeeeeeCcDIIIIiiiiUUUUuuuuNnSsYyyZz";
            for (var y = 0; y < strAccentsLen; y++) {
            if (accents.indexOf(strIn[y]) != -1) {
                strAccentsOut[y] = accentsOut.substr(accents.indexOf(strIn[y]), 1);
            } else
                strAccentsOut[y] = strIn[y];
            }
            strAccentsOut = strAccentsOut.join('');
            return strAccentsOut;
        }
    }
    
})(jQuery);