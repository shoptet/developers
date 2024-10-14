module.exports = AddFallbackJsonContent;

function AddFallbackJsonContent() {
    console.log("Adding fallback JSON content ...");
    return {
        Operation: {
            enter(target, ctx) {
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
            }
        },
    }
};
