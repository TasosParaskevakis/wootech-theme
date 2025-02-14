import { registerBlockType } from '@wordpress/blocks';
import { InspectorControls, useBlockProps, MediaUpload } from '@wordpress/block-editor';
import { PanelBody, TextControl, SelectControl, Button } from '@wordpress/components';
import { useEffect } from '@wordpress/element';

registerBlockType('wootech/home-banner', {
    title: 'Home Banner',
    icon: 'cover-image',
    category: 'common',
    attributes: {
        title: { type: 'string', default: 'Default Title' },
        description: { type: 'string', default: 'Short Description' },
        image: { type: 'string', default: '' },
        position: { type: 'string', default: 'left' },
    },
    edit: (props) => {
        const { attributes, setAttributes } = props;
        const blockProps = useBlockProps();

        return (
            <>
                <InspectorControls>
                    <PanelBody title="Banner Settings">
                        <TextControl
                            label="Title"
                            value={attributes.title}
                            onChange={(value) => setAttributes({ title: value })}
                        />
                        <TextControl
                            label="Description"
                            value={attributes.description}
                            onChange={(value) => setAttributes({ description: value })}
                        />
                        <MediaUpload
                            onSelect={(media) => setAttributes({ image: media.url })}
                            allowedTypes={['image']}
                            render={({ open }) => (
                                <Button onClick={open} isPrimary>
                                    Choose Image
                                </Button>
                            )}
                        />
                        <SelectControl
                            label="Image Position"
                            value={attributes.position}
                            options={[
                                { label: 'Left', value: 'left' },
                                { label: 'Right', value: 'right' },
                            ]}
                            onChange={(value) => setAttributes({ position: value })}
                        />
                    </PanelBody>
                </InspectorControls>
                <div {...blockProps} className={`home-banner ${attributes.position}`}>
                    {attributes.image && <img src={attributes.image} alt="Banner Image" />}
                    <h2>{attributes.title}</h2>
                    <p>{attributes.description}</p>
                </div>
            </>
        );
    },
    save: () => null, // Server-side rendering via PHP
});