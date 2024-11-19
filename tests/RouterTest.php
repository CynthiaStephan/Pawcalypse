<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use App\Router;
use ReflectionClass;

class RouterTest extends TestCase {
    private $router;

    protected function setUp(): void {
        $this->router = new Router();
    }

    /** @test */
    public function it_can_add_routes() {
        // Ajouter une route avec une closure
        $this->router->add('/test', function () {
            return "Route trouvée";
        });

        // Utiliser Reflection pour accéder à la propriété privée $routes
        $reflection = new ReflectionClass($this->router);
        $property = $reflection->getProperty('routes');
        $property->setAccessible(true);

        $routes = $property->getValue($this->router);

        // Vérifier que la route est bien enregistrée
        $this->assertArrayHasKey('/test', $routes);
    }

    /** @test */
    public function it_can_dispatch_to_a_callback() {
        // Simuler une route avec une closure
        $this->router->add('/callback', function () {
            echo "Callback exécuté";
        });

        // Capturer la sortie
        ob_start();
        $this->router->dispatch('/callback');
        $output = ob_get_clean();

        // Vérifier que le callback est exécuté
        $this->assertEquals("Callback exécuté", $output);
    }

    /** @test */
    public function it_sends_404_for_unknown_route() {
        // Capturer la sortie
        ob_start();
        $this->router->dispatch('/unknown');
        $output = ob_get_clean();

        // Vérifier la réponse HTTP et le contenu
        $this->assertSame("<h1>404 Not Found</h1><p>Route introuvable.</p>", $output);
    }

    /** @test */
    public function it_sends_404_for_invalid_callback() {
        // Ajouter une route avec un callback non valide
        $this->router->add('/invalid', 'NonExistentFunction');

        // Capturer la sortie
        ob_start();
        $this->router->dispatch('/invalid');
        $output = ob_get_clean();

        // Vérifier la réponse HTTP et le contenu
        $this->assertSame("<h1>404 Not Found</h1><p>La route existe, mais la fonction associée est invalide.</p>", $output);
    }
}
