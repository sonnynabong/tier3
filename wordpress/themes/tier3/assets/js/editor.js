(function (wp) {
  const { registerBlockType } = wp.blocks;
  const { InspectorControls, MediaUpload, MediaUploadCheck, useBlockProps } = wp.blockEditor;
  const { PanelBody, TextControl, TextareaControl, Button, BaseControl } = wp.components;
  const { Fragment, createElement: el } = wp.element;
  const ServerSideRender = wp.serverSideRender;

  function text(label, value, onChange, multiline) {
    const Control = multiline ? TextareaControl : TextControl;
    return el(Control, {
      label,
      value: value || '',
      onChange,
      __nextHasNoMarginBottom: true,
      __next40pxDefaultSize: true,
    });
  }

  function media(label, id, onSelect) {
    return el(
      BaseControl,
      { label, __nextHasNoMarginBottom: true },
      el(
        MediaUploadCheck,
        {},
        el(MediaUpload, {
          onSelect: function (mediaItem) {
            onSelect(mediaItem.id);
          },
          allowedTypes: ['image'],
          value: id,
          render: function (obj) {
            return el(
              Fragment,
              {},
              el(
                Button,
                { variant: 'secondary', onClick: obj.open },
                id ? 'Replace image' : 'Select image'
              ),
              id
                ? el(
                    Button,
                    {
                      variant: 'link',
                      isDestructive: true,
                      onClick: function () {
                        onSelect(0);
                      },
                    },
                    'Remove'
                  )
                : null
            );
          },
        })
      )
    );
  }

  function preview(name, attributes) {
    return el(ServerSideRender, { block: name, attributes: attributes });
  }

  function SectionEdit(props) {
    const blockProps = useBlockProps({ className: 'tier3-section-editor' });
    return el(
      Fragment,
      {},
      el(InspectorControls, {}, el(PanelBody, { title: props.title, initialOpen: true }, props.fields)),
      el('div', blockProps, preview(props.name, props.attributes))
    );
  }

  function editor(title, fields, name, props) {
    return el(SectionEdit, {
      title: title,
      fields: fields,
      name: name,
      attributes: props.attributes,
    });
  }

  registerBlockType('tier3/hero', {
    edit: function (props) {
      const a = props.attributes;
      const set = props.setAttributes;
      return editor(
        'Hero',
        [
          text('Title line 1', a.titleLine1, function (v) { set({ titleLine1: v }); }),
          text('Title line 2', a.titleLine2, function (v) { set({ titleLine2: v }); }),
          text('Title line 3', a.titleLine3, function (v) { set({ titleLine3: v }); }),
          text('Description', a.description, function (v) { set({ description: v }); }, true),
          text('Primary button', a.primaryLabel, function (v) { set({ primaryLabel: v }); }),
          text('Primary URL', a.primaryUrl, function (v) { set({ primaryUrl: v }); }),
          text('Secondary link', a.secondaryLabel, function (v) { set({ secondaryLabel: v }); }),
          text('Secondary URL', a.secondaryUrl, function (v) { set({ secondaryUrl: v }); }),
          media('Bottle', a.bottleId, function (id) { set({ bottleId: id }); }),
          text('Caption brand', a.captionBrand, function (v) { set({ captionBrand: v }); }),
          text('Caption system', a.captionSystem, function (v) { set({ captionSystem: v }); }),
          text('Foot left', a.footLeftLabel, function (v) { set({ footLeftLabel: v }); }),
          text('Foot left URL', a.footLeftUrl, function (v) { set({ footLeftUrl: v }); }),
          text('Foot right', a.footRightLabel, function (v) { set({ footRightLabel: v }); }),
          text('Foot right URL', a.footRightUrl, function (v) { set({ footRightUrl: v }); }),
        ],
        'tier3/hero',
        props
      );
    },
    save: function () {
      return null;
    },
  });

  registerBlockType('tier3/results', {
    edit: function (props) {
      const a = props.attributes;
      const set = props.setAttributes;
      return editor(
        'Results',
        [
          text('Heading', a.heading, function (v) { set({ heading: v }); }),
          text('Stories link', a.storiesLabel, function (v) { set({ storiesLabel: v }); }),
          text('Stories URL', a.storiesUrl, function (v) { set({ storiesUrl: v }); }),
          text('Lead quote', a.leadQuote, function (v) { set({ leadQuote: v }); }, true),
          text('Lead name', a.leadName, function (v) { set({ leadName: v }); }),
          text('Lead meta', a.leadMeta, function (v) { set({ leadMeta: v }); }),
          media('Lead portrait', a.leadImageId, function (id) { set({ leadImageId: id }); }),
          text('Second quote', a.secondaryQuote, function (v) { set({ secondaryQuote: v }); }, true),
          text('Second name', a.secondaryName, function (v) { set({ secondaryName: v }); }),
          text('Second meta', a.secondaryMeta, function (v) { set({ secondaryMeta: v }); }, true),
          media('Second portrait', a.secondaryImageId, function (id) { set({ secondaryImageId: id }); }),
        ],
        'tier3/results',
        props
      );
    },
    save: function () {
      return null;
    },
  });

  registerBlockType('tier3/case-study', {
    edit: function (props) {
      const a = props.attributes;
      const set = props.setAttributes;
      return editor(
        'Case study',
        [
          media('Photo', a.imageId, function (id) { set({ imageId: id }); }),
          text('Quote', a.quote, function (v) { set({ quote: v }); }, true),
          text('Subquote', a.subquote, function (v) { set({ subquote: v }); }),
          text('Name', a.name, function (v) { set({ name: v }); }),
          text('Meta', a.meta, function (v) { set({ meta: v }); }),
          text('Case study link', a.caseLabel, function (v) { set({ caseLabel: v }); }),
          text('Case study URL', a.caseUrl, function (v) { set({ caseUrl: v }); }),
          text('More results', a.moreLabel, function (v) { set({ moreLabel: v }); }),
          text('More results URL', a.moreUrl, function (v) { set({ moreUrl: v }); }),
        ],
        'tier3/case-study',
        props
      );
    },
    save: function () {
      return null;
    },
  });

  registerBlockType('tier3/growth-band', {
    edit: function (props) {
      const a = props.attributes;
      const set = props.setAttributes;
      return editor(
        'Growth band',
        [
          text('Heading HTML', a.heading, function (v) { set({ heading: v }); }, true),
          text('Primary button', a.primaryLabel, function (v) { set({ primaryLabel: v }); }),
          text('Primary URL', a.primaryUrl, function (v) { set({ primaryUrl: v }); }),
          text('Secondary link', a.secondaryLabel, function (v) { set({ secondaryLabel: v }); }),
          text('Secondary URL', a.secondaryUrl, function (v) { set({ secondaryUrl: v }); }),
        ],
        'tier3/growth-band',
        props
      );
    },
    save: function () {
      return null;
    },
  });

  registerBlockType('tier3/process', {
    edit: function (props) {
      const a = props.attributes;
      const set = props.setAttributes;
      const steps = Array.isArray(a.steps) ? a.steps : [];
      const fields = [
        text('Title HTML', a.title, function (v) { set({ title: v }); }, true),
        text('Description', a.description, function (v) { set({ description: v }); }, true),
      ];
      steps.forEach(function (step, index) {
        fields.push(
          el(BaseControl, { key: 'step-' + index, label: 'Step ' + (index + 1) }, [
            text('Number', step.number, function (v) {
              const next = steps.slice();
              next[index] = Object.assign({}, step, { number: v });
              set({ steps: next });
            }),
            text('Title HTML', step.title, function (v) {
              const next = steps.slice();
              next[index] = Object.assign({}, step, { title: v });
              set({ steps: next });
            }, true),
            text('Body', step.body, function (v) {
              const next = steps.slice();
              next[index] = Object.assign({}, step, { body: v });
              set({ steps: next });
            }, true),
            text('Link', step.linkLabel, function (v) {
              const next = steps.slice();
              next[index] = Object.assign({}, step, { linkLabel: v });
              set({ steps: next });
            }),
            text('URL', step.linkUrl, function (v) {
              const next = steps.slice();
              next[index] = Object.assign({}, step, { linkUrl: v });
              set({ steps: next });
            }),
            media('Icon', step.iconId, function (id) {
              const next = steps.slice();
              next[index] = Object.assign({}, step, { iconId: id });
              set({ steps: next });
            }),
          ])
        );
      });
      return editor('Process', fields, 'tier3/process', props);
    },
    save: function () {
      return null;
    },
  });

  registerBlockType('tier3/practices', {
    edit: function (props) {
      const a = props.attributes;
      const set = props.setAttributes;
      const logos = Array.isArray(a.logos) ? a.logos : [];
      const fields = [
        text('Heading HTML', a.heading, function (v) { set({ heading: v }); }, true),
        text('Subheading', a.subheading, function (v) { set({ subheading: v }); }),
        text('Link', a.linkLabel, function (v) { set({ linkLabel: v }); }),
        text('URL', a.linkUrl, function (v) { set({ linkUrl: v }); }),
      ];
      logos.forEach(function (logo, index) {
        fields.push(
          media(logo.alt || 'Logo ' + (index + 1), logo.id, function (id) {
            const next = logos.slice();
            next[index] = Object.assign({}, logo, { id: id });
            set({ logos: next });
          })
        );
      });
      return editor('Practices', fields, 'tier3/practices', props);
    },
    save: function () {
      return null;
    },
  });

  registerBlockType('tier3/closing', {
    edit: function (props) {
      const a = props.attributes;
      const set = props.setAttributes;
      const questions = Array.isArray(a.questions) ? a.questions : [];
      const fields = [
        text('Title line 1', a.titleLine1, function (v) { set({ titleLine1: v }); }),
        text('Title line 2', a.titleLine2, function (v) { set({ titleLine2: v }); }),
        text('Title line 3', a.titleLine3, function (v) { set({ titleLine3: v }); }),
      ];
      questions.forEach(function (question, index) {
        fields.push(
          text('Question ' + (index + 1), question, function (v) {
            const next = questions.slice();
            next[index] = v;
            set({ questions: next });
          }, true)
        );
      });
      fields.push(
        text('Primary button', a.primaryLabel, function (v) { set({ primaryLabel: v }); }),
        text('Primary URL', a.primaryUrl, function (v) { set({ primaryUrl: v }); }),
        text('Secondary link', a.secondaryLabel, function (v) { set({ secondaryLabel: v }); }),
        text('Secondary URL', a.secondaryUrl, function (v) { set({ secondaryUrl: v }); })
      );
      return editor('Closing', fields, 'tier3/closing', props);
    },
    save: function () {
      return null;
    },
  });
})(window.wp);
