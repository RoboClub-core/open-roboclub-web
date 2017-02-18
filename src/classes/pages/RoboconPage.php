<?php

namespace App\Page;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Repo;

final class RoboconPage extends GenericPage {

	public function __invoke(Request $request, Response $response, $args) {
		$this->setTitle('Robocon');
		$this->setTemplate('robocon.twig');

		$robocon = null;
		if($request->isPost()) {
			$this->setTemplate('robocon-core.twig');
			$robocon = $request->getParsedBody();

			$this->addTwigObject($robocon);
		}

		$this->render_page($request, $response);
	}

};