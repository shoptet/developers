module.exports = {
    rules: {
        // This rule will add a fallback content type (application/json) where necessary
        'add-fallback-json-content': () => {
            return {
                // 'operation' applies the rule to every endpoint (operation) in the OpenAPI spec
                Operation: {
                    // The rule will be executed when any operation is processed
                    enter(operation, ctx) {
                        const responses = operation.responses;

                        // Iterate over all responses (200, 400, etc.)
                        for (const [statusCode, response] of Object.entries(responses)) {
                            const vendorSpecificContent = response.content?.['application/vnd.shoptet.v1.0+json'];

                            // If the vendor-specific media type is found and there is no application/json fallback
                            if (vendorSpecificContent && !response.content['application/json']) {
                                // Add application/json content with the same schema as the vendor-specific media type
                                response.content['application/json'] = { ...vendorSpecificContent };

                                // Optional: Logging for debugging purposes
                                ctx.log.info(
                                    `Added fallback content type 'application/json' for response ${statusCode} in path ${ctx.path.join('/')}`
                                );
                            }
                        }
                    },
                },
            };
        },
    },
};
