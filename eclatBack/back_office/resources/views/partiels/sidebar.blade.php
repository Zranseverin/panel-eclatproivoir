<!--start sidebar -->
       <aside class="sidebar-wrapper">
          <div class="iconmenu"> 
            <div class="nav-toggle-box">
              <div class="nav-toggle-icon"><i class="bi bi-list"></i></div>
            </div>
            <ul class="nav nav-pills flex-column">
              <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="Dashboards">
                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#pills-dashboards" type="button"><i class="bi bi-house-door-fill"></i></button>
              </li>
              <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="Application">
                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#pills-application" type="button"><i class="bi bi-grid-fill"></i></button>
              </li>
              <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="Parametre du site">
                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#pills-widgets" type="button"><i class="bi bi-briefcase-fill"></i></button>
              </li>
              <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="Devis">
                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#pills-ecommerce" type="button"><i class="bi bi-bag-check-fill"></i></button>
              </li>
              <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="Components">
                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#pills-components" type="button"><i class="bi bi-bookmark-star-fill"></i></button>
              </li>
              <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="Forms">
                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#pills-forms" type="button"><i class="bi bi-file-earmark-break-fill"></i></button>
              </li>
              <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="Tables">
                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#pills-tables" type="button"><i class="bi bi-file-earmark-spreadsheet-fill"></i></button>
              </li>
              <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="Authentication">
                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#pills-authentication" type="button"><i class="bi bi-lock-fill"></i></button>
              </li>
              <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="Icons">
                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#pills-icons" type="button"><i class="bi bi-cloud-arrow-down-fill"></i></button>
              </li>
              <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="Content">
                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#pills-content" type="button"><i class="bi bi-cone-striped"></i></button>
              </li>
              <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="Charts">
                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#pills-charts" type="button"><i class="bi bi-pie-chart-fill"></i></button>
              </li>
              <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="Maps">
                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#pills-maps" type="button"><i class="bi bi-pin-map-fill"></i></button>
              </li>
              <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="Pages">
                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#pills-pages" type="button"><i class="bi bi-award-fill"></i></button>
              </li>
              <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="Charts">
                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#pills-charts" type="button"><i class="bi bi-pie-chart-fill"></i></button>
              </li>
              <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="Maps">
                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#pills-maps" type="button"><i class="bi bi-pin-map-fill"></i></button>
              </li>
              <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="Pages">
                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#pills-pages" type="button"><i class="bi bi-award-fill"></i></button>
              </li>
            </ul>
          </div>
          <div class="textmenu">
            <div class="brand-logo">
              <img src="{{ asset('assets/images/logo.png') }}" width="60" alt=""/>
            </div>
            <div class="tab-content">
              <div class="tab-pane fade" id="pills-dashboards">
                <div class="list-group list-group-flush">
                  <div class="list-group-item">
                    <div class="d-flex w-100 justify-content-between">
                      <h5 class="mb-0">Dashboards</h5>
                    </div>
                    <small class="mb-0">Contenu reservé</small>
                  </div>
                  <a href="{{ route('admin.dashboard') }}" class="list-group-item"><i class="bi bi-cart-plus"></i>Dashboard</a>
                  <a href="{{ route('admin.dashboard') }}" class="list-group-item"><i class="bi bi-wallet"></i>Employés</a>
                  <a href="{{ route('admin.dashboard') }}" class="list-group-item"><i class="bi bi-bar-chart-line"></i>chauffeurs</a>
                  <a href="index4.html" class="list-group-item"><i class="bi bi-archive"></i>versements</a>
                  <a href="index5.html" class="list-group-item"><i class="bi bi-cast"></i>dépenses</a>
                </div>
              </div>
              <div class="tab-pane fade" id="pills-application">
                <div class="list-group list-group-flush">
                  <div class="list-group-item">
                    <div class="d-flex w-100 justify-content-between">
                      <h5 class="mb-0">Application</h5>
                    </div>
                    <small class="mb-0">Some placeholder content</small>
                  </div>
                  <a href="app-emailbox.html" class="list-group-item"><i class="bi bi-envelope"></i>Email</a>
                  <a href="app-chat-box.html" class="list-group-item"><i class="bi bi-chat-left-text"></i>Chat Box</a>
                  <a href="app-file-manager.html" class="list-group-item"><i class="bi bi-archive"></i>File Manager</a>
                  <a href="app-to-do.html" class="list-group-item"><i class="bi bi-check2-square"></i>Todo List</a>
                  <a href="app-invoice.html" class="list-group-item"><i class="bi bi-receipt"></i>Invoice</a>
                </div>
              </div>
              <div class="tab-pane fade" id="pills-widgets">
                <div class="list-group list-group-flush">
                  <div class="list-group-item">
                    <div class="d-flex w-100 justify-content-between">
                      <h5 class="mb-0">Parametre du site</h5>
                    </div>
                    <small class="mb-0">Contenu de remplacement</small>
                  </div>
                  <a href="{{ route('admin.logos.index') }}" class="list-group-item"><i class="bi bi-box"></i>Head</a>
                  <a href="{{ route('admin.navbar-brands.index') }}" class="list-group-item"><i class="bi bi-receipt"></i>section logo</a>
                  <a href="{{ route('admin.header-contacts.index') }}" class="list-group-item"><i class="bi bi-receipt"></i>Header</a>
                  <a href="{{ route('admin.navbars.index') }}" class="list-group-item"><i class="bi bi-receipt"></i>Menu</a>
                  <a href="{{ route('admin.hero_contents.index') }}" class="list-group-item"><i class="bi bi-bar-chart"></i>hero section</a>
                   <a href="{{ route('admin.services.index') }}" class="list-group-item"><i class="bi bi-bar-chart"></i>Services</a>
                    <a href="{{ route('admin.pricing_plans.index') }}" class="list-group-item"><i class="bi bi-bar-chart"></i>Formule</a>
                     <a href="{{ route('admin.blog_posts.index') }}" class="list-group-item"><i class="bi bi-bar-chart"></i>Guide</a>
                      <a href="{{ route('admin.team_members.index') }}" class="list-group-item"><i class="bi bi-bar-chart"></i>L'Equipe</a>
                      <a href="{{ route('admin.testimonials.index') }}" class="list-group-item"><i class="bi bi-bar-chart"></i>Temoignage</a>
                </div>
              </div>
              <div class="tab-pane fade" id="pills-ecommerce">
                <div class="list-group list-group-flush">
                  <div class="list-group-item">
                    <div class="d-flex w-100 justify-content-between">
                      <h5 class="mb-0">Devis</h5>
                    </div>
                    <small class="mb-0">Liste des devis</small>
                  </div>
                  <a href="{{ route('admin.appointments.index') }}"  class="list-group-item"><i class="bi bi-box-seam"></i>Liste des devis</a>
                  <a href="{{ route('admin.job-applications.index') }}" class="list-group-item"><i class="bi bi-box-seam"></i>Recrutement</a>
                  <a href="{{ route('admin.sent-emails.index') }}" class="list-group-item"><i class="bi bi-envelope"></i>Emails Envoyés</a>
                  <a href="{{ route('admin.email-configs.index') }}" class="list-group-item"><i class="bi bi-gear"></i>Configuration Email</a>
                  <a href="{{ route('admin.newsletter-subscribers.index') }}" class="list-group-item"><i class="bi bi-people"></i>Abonnés Newsletter</a>
                    <a href="{{ route('admin.job-postings.index') }}" class="list-group-item"><i class="bi bi-people"></i>Fiche de poste</a>
                </div>
              </div>
             
               
            </div>
          </div>
       </aside>
       <!--start sidebar -->
</```