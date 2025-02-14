(function () {
    const { registerBlockType } = wp.blocks;
    const { useBlockProps, MediaUpload } = wp.blockEditor;
    const { TextControl, Button, SelectControl } = wp.components;
    const { createElement } = wp.element;

    registerBlockType('wootech/info-block', {
        title: 'Info Block',
        icon: 'info',
        category: 'common',
        attributes: {
            imageUrl: { type: 'string', default: '' },
            title: { type: 'string', default: 'For Physicians' },
            tagline: { type: 'string', default: 'Control pressure. Reduce complications' },
            description: { type: 'string', default: 'The eyeView system features a non-invasive adjustment mechanism that allows for a simple and accurate control of intraocular pressure.' },
            url: { type: 'string', default: '#' },
            position: { type: 'string', default: 'left' },
        },
        edit: function (props) {
            return createElement(
                'div',
                useBlockProps({ className: 'relative flex flex-col pt-14 pb-7 lg:py-0 lg:flex-col' }),
                createElement(MediaUpload, {
                    onSelect: (media) => props.setAttributes({ imageUrl: media.url }),
                    allowedTypes: ['image'],
                    render: ({ open }) => createElement(
                        Button,
                        { onClick: open, isPrimary: true },
                        props.attributes.imageUrl ? 'Change Image' : 'Upload Image'
                    )
                }),
                createElement(TextControl, {
                    label: 'Title',
                    value: props.attributes.title,
                    onChange: (newTitle) => props.setAttributes({ title: newTitle }),
                }),
                createElement(TextControl, {
                    label: 'Tagline',
                    value: props.attributes.tagline,
                    onChange: (newTagline) => props.setAttributes({ tagline: newTagline }),
                }),
                createElement(TextControl, {
                    label: 'Description',
                    value: props.attributes.description,
                    onChange: (newDesc) => props.setAttributes({ description: newDesc }),
                }),
                createElement(TextControl, {
                    label: 'Learn More URL',
                    value: props.attributes.url,
                    onChange: (newUrl) => props.setAttributes({ url: newUrl }),
                }),
                createElement(SelectControl, {
                    label: 'Image Position',
                    value: props.attributes.position,
                    options: [
                        { label: 'Left', value: 'left' },
                        { label: 'Right', value: 'right' },
                    ],
                    onChange: (newPosition) => props.setAttributes({ position: newPosition }),
                })
            );
        },
        save: function () {
            return null; // Ensures PHP rendering
        }
    });
})();