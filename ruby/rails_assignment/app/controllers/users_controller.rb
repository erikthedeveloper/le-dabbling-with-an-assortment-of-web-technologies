class UsersController < Devise::RegistrationsController

  before_action :set_users

  before_action :set_user, only: :show

  def index
    @tasks = Task.order('created_at DESC').all
  end

  def show

  end

  private

  def set_users
    @users = User.includes(:tasks).order('tasks.created_at DESC').all
  end

  def set_user
    @user = User.includes(:tasks).find(params[:id])
  end
  # Also see DeviseController
end