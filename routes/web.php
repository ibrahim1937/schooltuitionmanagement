<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DemandeController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\ForgetPasswordController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\ProfileController;
use App\Mail\StyledMail;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::view('/','welcome')->name('home');


// Auth::routes();
Route::group(['middleware' => 'authenticatedmiddleware'], function(){

Route::view('/login','login')->name('loginpage');
Route::get('/register',[MainController::class, 'registerindex']);
Route::post('/logout', [MainController::class, 'logout'])->name('logout');
Route::view('/forget-password', 'forget-password')->name('forgetpasswordpage');
Route::post('/forget-password', [ForgetPasswordController::class, 'postEmail'])->name('forgetpassword');

//reset password routes
Route::get('/reset-password/{token}', [ResetPasswordController::class, 'getPassword']);
Route::post('/reset-password', [ResetPasswordController::class,'updatePassword'])->name('resetpassword');

Route::post('/login',[LoginController::class, 'login'])->name('login');
Route::post('/register',[MainController::class, 'register'])->name('register');

});




/* This route group is where the authenticated users go to */
Route::group(['middleware' => ['auth', 'session.timeout']], function(){

    // Route group for admin
    Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin'], function(){
        // all views
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/ajouterdesEtudiant', [AdminController::class , 'etudiant'])->name('addetudiant');
        Route::get('/listedesEtudiant', [AdminController::class , 'etudiantliste'])->name('listeetudiant');
        Route::view('/gestionfiliere', 'admin.pages.filiere')->name('filiere');
        Route::get('/gestionProfesseur', [AdminController::class, 'professeur'])->name('professeur');
        Route::view('/gestionAgentScolarite', 'admin.pages.agentscolarite')->name('agentscolarite');
        Route::view('/gestionAgentExamen', 'admin.pages.agentexamen')->name('agentexamen');
        Route::get('/gestionelement', [AdminController::class, 'element'])->name('element');
        Route::get('/gestionmodule', [AdminController::class, 'module'])->name('module');
        Route::get('/export', [AdminController::class, 'export'])->name('export');
        Route::get('/exportsample', [AdminController::class, 'exportsample'])->name('exportsample');
        Route::post('/import', [AdminController::class, 'import'])->name('import');
        Route::get('/logs', [AdminController::class, 'log'])->name('logspages');
        Route::get('/profile', [ProfileController::class, 'adminProfile'])->name('profilepage');

        // post
        Route::post('/gestionfiliere', [AdminController::class, 'gestionfiliere'])->name('gestionfiliere');
        Route::post('/gestionmodule', [AdminController::class, 'gestionModule'])->name('gestionmodule');
        Route::post('/gestionelement', [AdminController::class, 'gestionElement'])->name('gestionelement');
        Route::post('/gestionProfesseur', [AdminController::class, 'gestionProfesseur'])->name('gestionprofesseur');
        Route::post('/gestionAgentScolarite', [AdminController::class, 'gestionAgentScolarite'])->name('gestionagentscolarite');
        Route::post('/gestionAgentExamen', [AdminController::class, 'gestionAgentExamen'])->name('gestionagentexamen');
        Route::post('/ajouterdesEtudiant', [AdminController::class , 'gestionetudiant'])->name('gestionetudiant');
        Route::post('/listedesEtudiant', [AdminController::class , 'gestionetudiantliste'])->name('gestionetudiantliste');
        Route::post('/logs', [AdminController::class, 'gestionlogs'])->name('logs');
        Route::post('/profile', [ProfileController::class, 'gestionAdminProfile'])->name('profile');
        Route::post('/dashboard', [AdminController::class, 'gestionDashboard'])->name('gestiondashboard');
    });
    // Route group for etudiant
    Route::group(['prefix' => 'etudiant', 'as' => 'etudiant.', 'middleware' => 'etudiant'], function(){

         // Route::view('/dashboard', 'etudiant.pages.dashboard')->name('dashboard');
         Route::get('/dashboard', [DemandeController::class, 'dashboard'])->name('dashboard');
         Route::view('/scolarite', 'etudiant.pages.scolarite')->name('scolarite');
         Route::view('/rectfier', 'etudiant.pages.rectfier')->name('rectfier');
         Route::view('/livreeDemande', 'etudiant.pages.livreeDemande')->name('livreeDemande');
         Route::view('/refuserDemande', 'etudiant.pages.refuserDemande')->name('refuserDemande');
         Route::view('/accepterRectifier', 'etudiant.pages.accepterRectifier')->name('accepterRectifier');
         Route::view('/refuserRectifier', 'etudiant.pages.refuserRectifier')->name('refuserRectifier');
         Route::get('/profile', [ProfileController::class, 'etudiantProfile'])->name('profilepage');
         Route::post('/scolarite', [DemandeController::class, 'gestionscolarite'])->name('gestionscolarite');
         Route::get('/scolarite', [DemandeController::class, 'scolarite'])->name('scolarite');
         Route::get('/rectfier', [DemandeController::class, 'rectfier'])->name('rectfier');
         Route::post('/rectfier', [DemandeController::class, 'gestionrectfier'])->name('gestionrectfier');
         Route::post('/dashboard', [DemandeController::class, 'chart1'])->name('chart1');
         Route::post('/livreeDemande', [DemandeController::class, 'afficheLivreDemadeEtudian'])->name('livreeDemande');
         Route::post('/refuserDemande', [DemandeController::class, 'afficheLivreDemadeEtudian'])->name('refuserDemande');
         Route::post('/accepterRectifier', [DemandeController::class, 'afficherAccepteretRefuserEtudian'])->name('accepterRectifier1');
         Route::post('/refuserRectifier', [DemandeController::class, 'afficherAccepteretRefuserEtudian'])->name('refuserRectifier1');
         Route::post('/profile', [ProfileController::class, 'gestionEtudiantProfile'])->name('profile');
    });
    // Route group for Professeur
    Route::group(['prefix' => 'prof', 'as' => 'prof.', 'middleware' => 'professeur'], function(){
        Route::get('/dashboard', [DemandeController::class, 'dashboardprof'])->name('dashboard');
        Route::view('/rectifier', 'prof.pages.rectifier')->name('rectifier');
        Route::view('/historique', 'prof.pages.historique')->name('historique');
        Route::view('/accepter', 'prof.pages.accepter')->name('accepter');
        Route::view('/refuser', 'prof.pages.refuser')->name('refuser');
        Route::get('/profile', [ProfileController::class, 'profProfile'])->name('profilepage');
        Route::post('/rectifier', [DemandeController::class, 'demanderectifier'])->name('demanderectifier');
        Route::post('/accepter', [DemandeController::class, 'accepterrectifier'])->name('accepterrectifier');
        Route::post('/refuser', [DemandeController::class, 'refuserrectifier'])->name('refuserrectifier');
        Route::post('/historique', [DemandeController::class, 'getAllElementshistoriquerectifier'])->name('historiquerectifier');
        Route::post('/dashboard', [DemandeController::class, 'chart4'])->name('chart4');
        Route::post('/profile', [ProfileController::class, 'gestionprofProfile'])->name('profile');
    });
    // Route group for service de scolarite
    Route::group(['prefix' => 'service_de_scolarite', 'as' => 'ess.', 'middleware' => 'agentscolarite'], function(){

        Route::get('/dashboard', [DemandeController::class, 'dashboardess'])->name('dashboard');
        Route::view('/demande', 'ess.pages.damande')->name('demande');
        Route::view('/historique', 'ess.pages.historique')->name('historique');
        Route::view('/accepter', 'ess.pages.accepter')->name('accepter');
        Route::view('/accepterparese', 'ess.pages.accepterparese')->name('accepterparese');
        Route::view('/refuser', 'ess.pages.refuser')->name('refuser');
        Route::view('/livree', 'ess.pages.livree')->name('livree');
        Route::get('/profile', [ProfileController::class, 'essProfile'])->name('profilepage');

        // all posts
        Route::post('/demande', [DemandeController::class, 'gestiondemande'])->name('gestiondemande');
        Route::post('/refuser', [DemandeController::class, 'refuser'])->name('refuser');
        Route::post('/livree', [DemandeController::class, 'livree'])->name('livree');
        Route::post('/historique', [DemandeController::class, 'historique'])->name('historique');
        Route::post('/accepter', [DemandeController::class, 'accepter'])->name('accepter');
        Route::post('/accepterparese', [DemandeController::class, 'accepterparese'])->name('accepterparese');
        Route::post('/dashboard', [DemandeController::class, 'chart2'])->name('chart2');
        Route::post('/profile', [ProfileController::class, 'gestionessProfile'])->name('profile');






        // Route::get('/demande', [DemandeController::class, 'demande'])->name('demande');
    });
    // Route group for service d'examen
    Route::group(['prefix' => 'service_examen', 'as' => 'ese.', 'middleware' => 'agentexamen'], function(){
        Route::get('/dashboard', [DemandeController::class, 'dashboardese'])->name('dashboard');
        Route::view('/demandes', 'ese.pages.demandes')->name('demandes');
        Route::view('/historique', 'ese.pages.historique')->name('historique');
        Route::view('/accepter', 'ese.pages.accepter')->name('accepter');
        Route::view('/refuser', 'ese.pages.refuser')->name('refuser');
        Route::view('/livree', 'ese.pages.livree')->name('livree');
        Route::get('/profile', [ProfileController::class, 'eseProfile'])->name('profilepage');

        // all posts
        Route::post('/demandes', [DemandeController::class, 'demande'])->name('demandes');
        Route::post('/refuser', [DemandeController::class, 'eserefuser'])->name('eserefuser');
        Route::post('/accepter', [DemandeController::class, 'eseaccepter'])->name('eseaccepter');
        Route::post('/livree', [DemandeController::class, 'eselivree'])->name('eselivree');
        Route::post('/historique', [DemandeController::class, 'esehistorique'])->name('esehistorique');
        Route::post('/dashboard', [DemandeController::class, 'chart3'])->name('chart3');
        Route::post('/profile', [ProfileController::class, 'gestioneseProfile'])->name('profile');
    });

    // redirecting authenticated user
    Route::get('/routing',[MainController::class, 'routing'])->name('route');


});





//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');