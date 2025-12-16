{{-- MODERN ADMIN UI USAGE GUIDE --}}

{{--
HOW TO USE THE NEW MODERN ADMIN UI:

1. INCLUDE THE STYLES:
   Add @include('partials.admin-modern-styles') at the top of your blade file after @extends('layouts.app')

2. HERO SECTION:
   <div class="admin-hero">
       <div class="content">
           <div class="hero-left">
               <h1 class="hero-title">Page Title</h1>
               <p class="hero-subtitle">Description goes here</p>
               <div class="hero-stats">
                   <div class="hero-stat">
                       <div class="stat-value">123</div>
                       <div class="stat-label">Label</div>
                   </div>
               </div>
           </div>
           <div class="hero-right">
               <div class="time-badge">
                   <i class="fas fa-calendar-alt"></i>
                   {{ now()->translatedFormat('l, d F Y') }}
               </div>
           </div>
       </div>
   </div>

3. QUICK ACTIONS:
   <div class="admin-quick-actions">
       <a href="#" class="admin-quick-action primary">
           <div class="action-icon">
               <i class="fas fa-icon-name"></i>
           </div>
           <div class="action-label">Action Name</div>
           <div class="action-count">Description</div>
           @if($hasNotification)
               <span class="badge-notification">5</span>
           @endif
       </a>
   </div>

4. STATS CARDS:
   <div class="admin-stats-modern">
       <div class="admin-stat-card">
           <div class="stat-header">
               <div class="stat-icon">
                   <i class="fas fa-icon-name"></i>
               </div>
               <div class="stat-trend up">
                   <i class="fas fa-arrow-up"></i>
                   12%
               </div>
           </div>
           <div class="stat-content">
               <div class="stat-value">123</div>
               <div class="stat-label">Label</div>
               <div class="stat-description">Description text</div>
           </div>
       </div>
   </div>

5. MODERN TABLES:
   <div class="admin-table-modern">
       <div class="table-header">
           <div class="table-title">
               <div class="title-icon">
                   <i class="fas fa-icon-name"></i>
               </div>
               Table Title
           </div>
           <div class="table-actions">
               <div class="search-box">
                   <i class="fas fa-search search-icon"></i>
                   <input type="text" class="search-input" placeholder="Search...">
               </div>
               <a href="#" class="admin-btn-modern primary">
                   <i class="fas fa-plus"></i>
                   Add New
               </a>
           </div>
       </div>
       <div class="table-body">
           <!-- Your table content here -->
       </div>
   </div>

6. MODERN FORMS:
   <div class="admin-form-modern">
       <div class="form-title">
           <i class="fas fa-icon-name"></i>
           Form Title
       </div>
       <form>
           <div class="form-group">
               <label class="form-label">Label</label>
               <input type="text" class="form-control" placeholder="Enter text...">
           </div>
       </form>
   </div>

7. BUTTONS:
   <a href="#" class="admin-btn-modern primary">
       <i class="fas fa-icon-name"></i>
       Primary Button
   </a>
   <a href="#" class="admin-btn-modern success">
       <i class="fas fa-icon-name"></i>
       Success Button
   </a>
   <a href="#" class="admin-btn-modern outline">
       <i class="fas fa-icon-name"></i>
       Outline Button
   </a>

8. STATUS BADGES:
   <span class="admin-badge-modern active">
       <i class="fas fa-check"></i>
       Active
   </span>
   <span class="admin-badge-modern pending">
       <i class="fas fa-clock"></i>
       Pending
   </span>
   <span class="admin-badge-modern completed">
       <i class="fas fa-check-double"></i>
       Completed
   </span>
   <span class="admin-badge-modern cancelled">
       <i class="fas fa-times"></i>
       Cancelled
   </span>

9. EMPTY STATES:
   <div class="admin-empty-modern">
       <span class="empty-icon">📭</span>
       <h4 class="empty-title">No Data Found</h4>
       <p class="empty-text">Description of what to do next</p>
       <a href="#" class="empty-action">
           <i class="fas fa-plus"></i>
           Add First Item
       </a>
   </div>

10. ANIMATIONS:
    Add these classes for entrance animations:
    - animate-fade-in
    - animate-fade-in animate-delay-1 (for staggered animations)
    - animate-fade-in animate-delay-2
    - animate-fade-in animate-delay-3
    - animate-fade-in animate-delay-4

11. QUICK ACTION COLOR VARIANTS:
    - primary (blue gradient)
    - success (green gradient)
    - warning (amber gradient)
    - danger (red gradient)
    - info (cyan gradient)
    - purple (purple gradient)
    - pink (pink gradient)
    - cyan (cyan gradient)

12. SPECIAL EFFECTS:
    - Glass effect: class="admin-glass-effect"
    - Gradient text: class="admin-gradient-text"
    - Soft shadow: class="admin-shadow-soft"
    - Glow effect: class="admin-shadow-glow"

13. RESPONSIVE BREAKPOINTS:
    - Desktop: >1024px
    - Tablet: 768px - 1024px
    - Mobile: <768px

14. DARK MODE:
    The styles automatically support dark mode through the existing [data-theme="dark"] attribute

--}}

{{-- QUICK USAGE EXAMPLES --}}
@if(false)
{{-- BASIC USAGE --}}
@include('partials.admin-modern-styles')

<div class="admin-container">
    {{-- Hero section --}}
    <div class="admin-hero animate-fade-in">
        <h1 class="hero-title">My Admin Page</h1>
    </div>

    {{-- Stats --}}
    <div class="admin-stats-modern animate-fade-in animate-delay-1">
        <div class="admin-stat-card">
            <div class="stat-value">123</div>
            <div class="stat-label">Total Items</div>
        </div>
    </div>
</div>
@endif