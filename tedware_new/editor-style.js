(function() {
    tinymce.PluginManager.add('my_tinymce_plugin', function(ed, url) {
        ed.on('init', function() {
            ed.formatter.register('_inline_code', {inline: 'span', classes: 'code'});
            ed.formatter.register('_etc', {selector: 'pre', classes: 'etc'});
            ed.formatter.register('_pseudo', {selector: 'pre', classes: 'pseudo'});
			ed.formatter.register('_excel', {selector: 'pre', classes: 'excel'});
			ed.formatter.register('_vba', {selector: 'pre', classes: 'vba'});
			ed.formatter.register('_javascript', {selector: 'pre', classes: 'javascript'});
			ed.formatter.register('_html', {selector: 'pre', classes: 'xml'});
			ed.formatter.register('_css', {selector: 'pre', classes: 'css'});
			ed.formatter.register('_python', {selector: 'pre', classes: 'python'});
            ed.formatter.register('_info', {selector: 'p, ul', classes: 'info'});
            ed.formatter.register('_warn', {selector: 'p, ul', classes: 'warn'});
            ed.formatter.register('_img', {selector: 'p, ul', classes: 'img'});
            ed.formatter.register('_q', {selector: 'p, ul', classes: 'q'});
            ed.formatter.register('_file', {selector: 'p, ul', classes: 'file'});
            ed.formatter.register('_link', {selector: 'p, ul', classes: 'link'});
            ed.formatter.register('_cap', {selector: 'p', classes: 'cap'});
        });
        var remove_all = function() {
            ed.formatter.remove('_etc');
            ed.formatter.remove('_pseudo');
            ed.formatter.remove('_excel');
            ed.formatter.remove('_vba');
            ed.formatter.remove('_javascript');
            ed.formatter.remove('_html');
            ed.formatter.remove('_css');
            ed.formatter.remove('_python');
            ed.formatter.remove('_info');
            ed.formatter.remove('_warn');
            ed.formatter.remove('_img');
            ed.formatter.remove('_q');
            ed.formatter.remove('_file');
            ed.formatter.remove('_link');
            ed.formatter.remove('_cap');
			ed.formatter.remove('h2');
            ed.formatter.remove('pre');
			ed.formatter.remove('div');
        };
        ed.addShortcut('alt+q', 'insert span class code', 'my_inline_code');
        ed.addCommand('my_inline_code', function() {
            ed.formatter.apply('_inline_code');
        });
        ed.addShortcut('alt+1', 'conver to h2', 'sc_h2');
        ed.addCommand('sc_h2', function() {
            remove_all();
            ed.formatter.apply('h2');
        });
        ed.addShortcut('alt+2', 'conver to h2', 'sc_h2');
        ed.addCommand('sc_h2', function() {
            ed.formatter.apply('code');
        });
        ed.addButton( 'my_normal_button', {
            text: 'NORMAL',
            icon: false,
            title: 'Normal P',
            onclick: function() {
                remove_all();
                ed.formatter.apply('p');
            }
        });
        ed.addButton( 'my_h2_button', {
            text: 'HEADING',
            icon: false,
            title: 'Heading H2',
            onclick: function() {
                remove_all();
                ed.formatter.apply('h2');
            }
        });
        ed.addButton( 'my_info_button', {
            text: 'INFO',
            icon: false,
            title: 'Info P',
            onclick: function() {
                remove_all();
                ed.formatter.apply('_info');
            }
        });
        // ed.addButton( 'my_info_ul_button', {
        //     text: 'INFO-UL',
        //     icon: false,
        //     title: 'Info UL',
        //     onclick: function() {
        //         remove_all();
        //         ed.formatter.apply('_info_ul');
        //     }
        // });
        // ed.addButton( 'my_warn_button', {
        //     text: 'WARN',
        //     icon: false,
        //     title: 'Warn P',
        //     onclick: function() {
        //         remove_all();
        //         ed.formatter.apply('_warn');
        //     }
        // });
        // ed.addButton( 'my_file_button', {
        //     text: 'FILE',
        //     icon: false,
        //     title: 'File P',
        //     onclick: function() {
        //         remove_all();
        //         ed.formatter.apply('_file');
        //     }
        // });
        // ed.addButton( 'my_link_button', {
        //     text: 'LINK',
        //     icon: false,
        //     title: 'Link P',
        //     onclick: function() {
        //         remove_all();
        //         ed.formatter.apply('_link');
        //     }
        // });
        // ed.addButton( 'my_q_button', {
        //     text: 'QUOTATION',
        //     icon: false,
        //     title: 'Quotation P',
        //     onclick: function() {
        //         remove_all();
        //         ed.formatter.apply('_q');
        //     }
        // });
        // ed.addButton( 'my_img_button', {
        //     text: 'IMAGE',
        //     icon: false,
        //     title: 'Image P',
        //     onclick: function() {
        //         remove_all();
        //         ed.formatter.apply('_img');
        //     }
        // });
        ed.addButton( 'my_cap_button', {
            text: 'CAPTION',
            icon: false,
            title: 'Caption P',
            onclick: function() {
                remove_all();
                ed.formatter.apply('_cap');
            }
        });
// 		ed.addButton( 'my_pre_button', {
//             text: 'PRE',
//             icon: false,
//             title: 'PRE',
//             onclick: function() {
//                 remove_all();
//                 ed.formatter.apply('pre');
//             }
//         });
        ed.addButton( 'my_etc_button', {
            text: 'ETC',
            icon: false,
            title: 'Code ETC',
            onclick: function() {
                remove_all();
				ed.formatter.apply('pre');
                ed.formatter.apply('_etc');
                ed.formatter.apply('code');
            }
        });
        ed.addButton( 'my_pseudo_button', {
            text: 'PSEUDO',
            icon: false,
            title: 'Code PSEUDO',
            onclick: function() {
                remove_all();
				ed.formatter.apply('pre');
                ed.formatter.apply('_pseudo');
                ed.formatter.apply('code');
            }
        });
        ed.addButton( 'my_excel_button', {
            text: 'EXCEL',
            icon: false,
            title: 'Code Excel',
            onclick: function() {
                remove_all();
				ed.formatter.apply('pre');
                ed.formatter.apply('_excel');
                ed.formatter.apply('code');
            }
        });
		ed.addButton( 'my_vba_button', {
            text: 'VBA',
            icon: false,
            title: 'Code VBA',
            onclick: function() {
                remove_all();
				ed.formatter.apply('pre');
                ed.formatter.apply('_vba');
                ed.formatter.apply('code');
            }
        });
		ed.addButton( 'my_javascript_button', {
            text: 'JAVASCRIPT',
            icon: false,
            title: 'Code Javascript',
            onclick: function() {
                remove_all();
				ed.formatter.apply('pre');
                ed.formatter.apply('_javascript');
                ed.formatter.apply('code');
            }
        });
		ed.addButton( 'my_html_button', {
            text: 'HTML',
            icon: false,
            title: 'Code HTML',
            onclick: function() {
                remove_all();
				ed.formatter.apply('pre');
                ed.formatter.apply('_html');
                ed.formatter.apply('code');
            }
        });
		ed.addButton( 'my_css_button', {
            text: 'CSS',
            icon: false,
            title: 'Code CSS',
            onclick: function() {
                remove_all();
				ed.formatter.apply('pre');
                ed.formatter.apply('_css');
                ed.formatter.apply('code');
            }
        });
		ed.addButton( 'my_python_button', {
            text: 'PYTHON',
            icon: false,
            title: 'Code Python',
            onclick: function() {
                remove_all();
				ed.formatter.apply('pre');
                ed.formatter.apply('_python');
                ed.formatter.apply('code');
            }
        });
    });
})();
