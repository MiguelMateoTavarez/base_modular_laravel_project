<?php

namespace Modules\Testmodule\Eloquents\Contracts\Second\Third;

use Illuminate\Http\Request;

interface ThirdInterface
{
    public function index();

    public function store(Request $request);

    public function show($id);

    public function update(Request $request, $id);

    public function destroy($id);
}
