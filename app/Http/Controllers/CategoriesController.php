<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoriesController extends Controller {
  /**
   * Display a listing of the resource.
   */
  public function index() {
    return view('categories.index'); //folder auth-> categories -> file index
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create() {
    return view('categories.create'); //folder auth-> categories -> file index
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request) {
    //
  }

  /**
   * Display the specified resource.
   */
  public function show(string $id) {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(string $id) {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, string $id) {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id) {
    //
  }
}
