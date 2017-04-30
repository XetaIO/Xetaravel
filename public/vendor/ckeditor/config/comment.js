/**
 * CKEditor config for comment on blog.
 */

CKEDITOR.editorConfig = function (config) {
    config.language = 'en';
    config.skin = 'bootstrapck';

    config.toolbar = [
        { name: 'styles', items: ['Styles', 'Format', 'FontSize'] },
        { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Strike'] },
        { name: 'links', items: ['Link', 'Unlink'] },
        { name: 'insert', items: ['Image', 'Table', 'HorizontalRule'] },
        { name: 'paragraph', items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent'] },
        { name: 'editing', items: ['Scayt'] },
        
        { name: 'others', items: ['Blockquote', 'pbckcode', 'Smiley'] },
        { name: 'tools', items: ['Maximize'] },
        { name: 'document', items: ['Source'] },
    ];

    config.extraPlugins = 'pbckcode';
    config.removePlugins = 'contextmenu,liststyle,tabletools,forms';
    config.removeDialogTabs = 'image:advanced;image:Link;link:advanced;link:target;';
    
    config.fontSize_sizes = '8/8px;10/10px;12/12px;14/14px;16/16px;18/18px;24/24px;36/36px;';
    config.format_tags = 'p;h1;h2;h3;h4;h5;pre;address;div';

    config.pbckcode = {
        cls: '',
        highlighter: 'PRETTIFY',
        modes: [['HTML', 'html'], ['CSS', 'css'], ['PHP', 'php'], ['JavaScript', 'javascript']],
        theme: 'tomorrow_night',
        tab_size: '4'
    };
};
