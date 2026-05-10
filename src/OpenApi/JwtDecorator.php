<?php

namespace App\OpenApi;

use ApiPlatform\OpenApi\Factory\OpenApiFactoryInterface;
use ApiPlatform\OpenApi\OpenApi;
use ApiPlatform\OpenApi\Model\SecurityScheme;
use Symfony\Component\DependencyInjection\Attribute\AsDecorator;

#[AsDecorator('api_platform.openapi.factory')]
/*
    Grâce à cette classe plus besoin de taper le mot "Bearer"
    dans le boutton Authorize (sur /api#)
*/
class JwtDecorator implements OpenApiFactoryInterface
{
    public function __construct(private OpenApiFactoryInterface $decorated)
    {
    }

    public function __invoke(array $context = []): OpenApi
    {
        // récupère la doc générée par API Platform
        $openApi = ($this->decorated)($context);

        $components = $openApi->getComponents();
        $securitySchemes = $components->getSecuritySchemes() ?: new \ArrayObject();

        // définit comment le cadenas doit se comporter
        $securitySchemes['Bearer'] = new SecurityScheme(
            type: 'http',
            scheme: 'bearer',
            bearerFormat: 'JWT',
            description: "Collez uniquement votre token JWT ici (SANS écrire le mot 'Bearer')"
        );

        // force l'application du token sur TOUTES les routes
        $openApi = $openApi->withSecurity([['Bearer' => []]]);

        return $openApi;
    }
}