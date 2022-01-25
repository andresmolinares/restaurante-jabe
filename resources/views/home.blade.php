@extends('layouts.app')

@section('content')
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

    <title>Restaurant JABE</title>
  </head>
  <body style="background: gray">
   <div class="container">

        <div class="row">
            <div class="col-sm-22">
                <div>
                    <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-indicators">
                          <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                          <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
                          <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
                          <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="3" aria-label="Slide 4"></button>

                        </div>
                        <div class="carousel-inner">
                            <h3 style="text-align: center"><b>
                                ¡ Bienvenidos a la web de domicilios Restaurant JABE !</b>
                            </h3>
                            <center><hr width="50%"></center>

                          <div class="carousel-item active">
                            <img src="\restaurant_jabe\resources\views\images\dos.png" class="d-block w-100" alt="..." width="200px" height="400px"  title="Restaurant JABE" >
                            <div class="carousel-caption d-none d-md-block">

                            </div>
                          </div>
                          <div class="carousel-item">
                            <img src="https://www.atriumpizzayburger.com/sites/default/files/images/especialidades_burger_1.png" class="d-block w-100" alt="..." width="200px" height="450px" title="Hamburguesas">
                            <div class="carousel-caption d-none d-md-block">

                            </div>
                          </div>
                          <div class="carousel-item">
                            <img src="https://www.atriumpizzayburger.com/sites/default/files/images/especialidades_postres.png" class="d-block w-100" alt="..." width="200px" height="450px" title="Postres">
                            <div class="carousel-caption d-none d-md-block">

                            </div>
                          </div>
                          <div class="carousel-item">
                            <img src="https://www.atriumpizzayburger.com/sites/default/files/images/especialidades_asados_0.png" class="d-block w-100" alt="..." width="200px" height="450px"  title="Asados">
                            <div class="carousel-caption d-none d-md-block">

                            </div>
                          </div>
                        </div>

                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                          <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                          <span class="carousel-control-next-icon" aria-hidden="true"></span>
                          <span class="visually-hidden">Next</span>
                        </button>
                      </div>
                </div>
                <center><hr width="50%"></center>
                {{--Carrusel de opiniones--}}
                <div class="carousel-inner">
                    <h3 style="text-align: center"><b>
                        ¡Esto dicen nuestros clientes!</b>
                    </h3>
                    <center><hr width="50%"></center>
                <div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                      <div class="carousel-item active">
                          <center>
                            <img src="\restaurant_jabe\resources\views\images\rating.png" class="d-block w-90 h-50" alt="..." width="200px" height="400px"  title="rating" >

                          </center>

                      </div>

                      @foreach ($ratings as $rating)
                      <div class="carousel-item">
                        <div class="row justify-content-center align-items-center">
                            <div class="col-sm-8">
                          <div class="card">
                              <div class="card-body">
                                  <center>
                                @if ($rating->stars == 5)
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                                @else

                                @if ($rating->stars == 4)
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>

                                @else
                                @if ($rating->stars == 3)
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                                @else
                                @if ($rating->stars == 2)
                                <i class="fas fa-star"></i><i class="fas fa-star"></i>
                                @else
                                @if ($rating->stars == 1)
                                <i class="fas fa-star"></i>

                                @endif
                                @endif
                                @endif
                                @endif
                                @endif

                                <h3><i>"{{$rating->description}}"<i></h3>


                              </div>
                          </div>
                          </div>
                        </div>

                      </div>
                      @endforeach


                    </div>
                  </div>


            </div>

          </div>
        </div>






   </div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-eMNCOe7tC1doHpGoWe/6oMVemdAVTMs2xqW4mwXrXsW0L84Iytr2wi5v2QjrP/xp" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.min.js" integrity="sha384-cn7l7gDp0eyniUwwAZgrzD06kc/tftFf19TOAs2zVinnD/C7E91j9yyk5//jjpt/" crossorigin="anonymous"></script>


-->

<!-- Footer -->
<footer class="bg-dark text-center text-white" style="position: relative; top: 60px">
    <!-- Grid container -->
    <div class="container p-4">
      <!-- Section: Social media -->
      <section class="mb-4">
        <!-- Facebook -->
        <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"
          ><i class="fab fa-facebook-f"></i
        ></a>

        <!-- Twitter -->
        <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"
          ><i class="fab fa-twitter"></i
        ></a>

        <!-- Google -->
        <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"
          ><i class="fab fa-google"></i
        ></a>

        <!-- Instagram -->
        <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"
          ><i class="fab fa-instagram"></i
        ></a>

        <!-- Linkedin -->
        <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"
          ><i class="fab fa-linkedin-in"></i
        ></a>

        <!-- Github -->
        <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"
          ><i class="fab fa-github"></i
        ></a>
      </section>
      <!-- Section: Social media -->

      <!-- Section: Form -->
      <section class="">
        <form action="">
          <!--Grid row-->
          <div class="row d-flex justify-content-center">
            <!--Grid column-->
            <div class="col-auto">
              <p class="pt-2">
                <strong>Sign up for our newsletter</strong>
              </p>
            </div>
            <!--Grid column-->

            <!--Grid column-->
            <div class="col-md-5 col-12">
              <!-- Email input -->
              <div class="form-outline form-white mb-4">
                <input type="email" id="form5Example2" class="form-control" />
                <label class="form-label" for="form5Example2">Email address</label>
              </div>
            </div>
            <!--Grid column-->

            <!--Grid column-->
            <div class="col-auto">
              <!-- Submit button -->
              <button type="submit" class="btn btn-outline-light mb-4">
                Subscribe
              </button>
            </div>
            <!--Grid column-->
          </div>
          <!--Grid row-->
        </form>
      </section>
      <!-- Section: Form -->

      <!-- Section: Text -->
      <section class="mb-4">
        <p>
          Restaurant JABE <br>
          Dirección Manga <br>
          Tel:  654-4654
        </p>
      </section>
      <!-- Section: Text -->

      <!-- Section: Links -->

      <!-- Section: Links -->
    </div>
    <!-- Grid container -->

    <!-- Copyright -->
    <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
      © 2020 Copyright:
      <a class="text-white" href="#">Resrtaurant JABE</a>
    </div>
    <!-- Copyright -->
  </footer>
  <!-- Footer -->
  </body>
</html>


@endsection
