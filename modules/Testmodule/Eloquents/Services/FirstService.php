<?php

namespace Modules\Testmodule\Eloquents\Services;

use Illuminate\Http\Request;
use Modules\Testmodule\Eloquents\Contracts\FirstInterface;

class FirstService implements FirstInterface
{
        //
        public function index()
        {
            // TODO: Implement index() method.
        }

        public function store(Request $request)
        {
            // TODO: Implement store() method.
        }

        public function show($id)
        {
            // TODO: Implement show() method.
        }

        public function update(Request $request, $id)
        {
            // TODO: Implement update() method.
        }

        public function destroy($id)
        {
            // TODO: Implement destroy() method.
        }
}
