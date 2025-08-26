<?php

namespace App\Core;
require_once __DIR__ . '/Response.php';
use App\Core\Response;
// use App\Core\Request;


class Controller {
  protected Response $res;
  public function __construct() { $this->res = new Response(); }
  protected function ok($data) { $this->res->json(['success'=>true,'data'=>$data], 200); }
  protected function created($data) { $this->res->json(['success'=>true,'data'=>$data], 201); }
  protected function fail($msg, int $code=400) { $this->res->json(['success'=>false,'error'=>$msg], $code); }
}
