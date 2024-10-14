const AddFallbackJsonDecorator = require('./decorators/add-fallback-json-content.js');

module.exports =  function contentTypeModifierPlugin() {
    return {
        id: "content-type-modifier",
        decorators: {
            oas3: {
                "add-fallback-json": AddFallbackJsonDecorator,
            },
        },
    };
}
