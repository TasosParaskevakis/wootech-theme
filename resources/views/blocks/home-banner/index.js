(function () {
    const { registerBlockType } = wp.blocks;
    const { useBlockProps, MediaUpload } = wp.blockEditor;
    const { TextControl, Button } = wp.components;
    const { createElement } = wp.element;

    registerBlockType('wootech/home-banner', {
        title: 'Home Banner',
        icon: 'cover-image',
        category: 'common',
        attributes: {
            imageUrl: { type: 'string', default: '' },
            title: { type: 'string', default: 'Revolutionizing the surgical treatment of eyes.' },
            description: { type: 'string', default: 'PRODUCTS' },
        },
        edit: function (props) {
            return createElement(
                'div',
                useBlockProps({ className: 'relative w-full h-[330px] md:h-full' }),
                createElement(MediaUpload, {
                    onSelect: (media) => props.setAttributes({ imageUrl: media.url }),
                    allowedTypes: ['image'],
                    render: ({ open }) =>
                        createElement(
                            Button,
                            { onClick: open, isPrimary: true },
                            props.attributes.imageUrl ? 'Change Image' : 'Upload Image'
                        ),
                }),
                createElement(TextControl, {
                    label: 'Title',
                    value: props.attributes.title,
                    onChange: (newTitle) => props.setAttributes({ title: newTitle }),
                }),
                createElement(TextControl, {
                    label: 'Description',
                    value: props.attributes.description,
                    onChange: (newDesc) => props.setAttributes({ description: newDesc }),
                })
            );
        },
        save: function () {
            return null; // Ensures PHP rendering
        },
    });
})();