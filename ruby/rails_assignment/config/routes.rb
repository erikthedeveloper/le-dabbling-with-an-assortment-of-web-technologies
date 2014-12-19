Rails.application.routes.draw do
  devise_for :users, controllers: {registrations: "users"}
  devise_scope :user do
    resources :users
    resources :tasks do
      # route 'toggle_complete'
    end
  end
  root 'pages#home'
end
