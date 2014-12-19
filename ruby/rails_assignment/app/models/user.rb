class User < ActiveRecord::Base
  # Include default devise modules. Others available are:
  # :confirmable, :lockable, :timeoutable and :omniauthable
  devise :database_authenticatable, :registerable,
         :recoverable, :rememberable, :trackable, :validatable

  validates_presence_of :first_name, :last_name, :email
  validates_format_of :email, :with => /\A([^@\s]+)@((?:[-a-z0-9]+\.)+[a-z]{2,})\z/i, message: 'not a valid email format'

  has_many :tasks, foreign_key: 'assigned_to'
  has_many :tasks_created, foreign_key: 'created_by', class_name: 'Task'

  def display_name
    "#{last_name}, #{first_name}"
  end
end
