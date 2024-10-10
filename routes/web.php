<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\SignupController;
use App\Http\Controllers\Dashboard\HomeController as DashboardHomeController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\SiteSettingController;
use App\Http\Controllers\Dashboard\UserController as DashboardUserController;
use App\Http\Controllers\Dashboard\JourneyController as DashboardJourneyController;
use App\Http\Controllers\Dashboard\PlacesController as DashboardPlacesController;
use App\Http\Controllers\Dashboard\LocationsController as DashboardLocationsController;
use App\Http\Controllers\Dashboard\ExpensesController as DashboardExpensesController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\UserController;
use App\Http\Controllers\Frontend\JourneyController;
use Illuminate\Support\Facades\Route;

Route::name("frontend.")->group(function() {
    Route::get("/", [HomeController::class, "index"])->name("home");
    Route::get("/journey/{id}", [JourneyController::class, "view"])->name("journey");
    Route::get("/journies", [JourneyController::class, "index"])->name("journies");
    Route::get("/journies/view", [JourneyController::class, "view"])->name("journies.view");
    Route::get("/user/{username}", [UserController::class, "index"])->name("user");
});

Route::name("auth.")->group(function() {
    Route::get("/signup", [SignupController::class, "index"])->name("signup");
    Route::post("/signup", [SignupController::class, "signup"])->name("signup.submit");
    Route::get("/login", [LoginController::class, "index"])->name("login");
    Route::post("/login", [LoginController::class, "login"])->name("login.submit");
    Route::post("/logout", [LogoutController::class, "index"])->name("logout");
});

Route::name("dashboard.")->prefix("/dashboard")->middleware(["auth"])->group(function() {
    // dashboard home
    Route::get("/", [DashboardHomeController::class, "index"])->name("home");
    Route::get("/locations/add", [DashboardPlacesController::class, "create"])->name("locations.add");
    Route::get("/expenses/add", [DashboardPlacesController::class, "create"])->name("expenses.add");
    Route::get("/places/add", [DashboardPlacesController::class, "create"])->name("places.add");
    Route::get("/journies/view", [DashboardJourneyController::class, "index"])->name("journies.view");

    Route::post("/places/edit", [DashboardPlacesController::class, "edit"])->name("places.edit");
    Route::post("/places/destroy", [DashboardPlacesController::class, "destroy"])->name("places.destroy");

    Route::post("/locations/edit", [DashboardLocationsController::class, "edit"])->name("locations.edit");
    Route::post("/locations/destroy", [DashboardLocationsController::class, "destroy"])->name("locations.destroy");

    Route::post("/expenses/edit", [DashboardExpensesController::class, "edit"])->name("expenses.edit");
    Route::post("/expenses/destroy", [DashboardExpensesController::class, "destroy"])->name("expenses.destroy");


    Route::prefix("/journies")->name("journies.")->controller(DashboardJourneyController::class)->group(function() {
        Route::get("/{id}/status", "status")->name("status");
        Route::get("/{id}/restore", "restore")->name("restore");
        Route::delete("/{id}/delete", "delete")->name("delete");
    });
    Route::resource("/journies", DashboardJourneyController::class)->except(["show"]);

    Route::get("/locations/add/{jourrneyId}", [DashboardLocationsController::class, "create"])->name("locations.add");
    Route::post("/locations/add/{journeyId}", [DashboardLocationsController::class, "store"])->name("locations.store");
    Route::resource("/locations", DashboardLocationsController::class)->except(["show", 'index', 'create', 'add', 'store']);

    Route::get("/places/add/{journeyId}", [DashboardPlacesController::class, "create"])->name("places.add");
    Route::post("/places/add/{journeyId}", [DashboardPlacesController::class, "store"])->name("places.store");
    Route::resource("/places", DashboardPlacesController::class)->except(["show", 'index', 'create', 'add', 'store']);

    Route::get("/expenses/add/{journeyId}", [DashboardExpensesController::class, "create"])->name("expenses.add");
    Route::post("/expenses/add/{journeyId}", [DashboardExpensesController::class, "store"])->name("expenses.store");
    Route::resource("/expenses", DashboardExpensesController::class)->except(["show", 'index', 'create', 'add', 'store']);


    // users
    Route::prefix("/users")->name("users.")->controller(DashboardUserController::class)->middleware(["admin"])->group(function() {
        Route::get("/{id}/status", "status")->name("status");
    });
    Route::resource("/users", DashboardUserController::class)->middleware(["admin"]);

    // settings
    Route::prefix("/settings")->name("settings.")->middleware(["admin"])->group(function() {
        // site settings
        Route::get("/site-settings", [SiteSettingController::class, "index"])->name("site");
        Route::post("/site-settings", [SiteSettingController::class, "update"])->name("site.update");
        // profile update
        Route::get("/profile", [ProfileController::class, "index"])->withoutMiddleware(["admin"])->name("profile");
        Route::post("/profile", [ProfileController::class, "update"])->withoutMiddleware(["admin"])->name("profile.update");
        // password change
        Route::get("/change-password", [ProfileController::class, "password"])->withoutMiddleware(["admin"])->name("password");
        Route::post("/change-password", [ProfileController::class, "passwordUpdate"])->withoutMiddleware(["admin"])->name("password.update");
       
        
    });
});
