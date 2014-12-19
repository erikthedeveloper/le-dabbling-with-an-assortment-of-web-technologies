# This file should contain all the record creation needed to seed the database with its default values.
# The data can then be loaded with the rake db:seed (or created alongside the db with db:setup).
#
# Examples:
#
#   cities = City.create([{ name: 'Chicago' }, { name: 'Copenhagen' }])
#   Mayor.create(name: 'Emanuel', city: cities.first)

joe = User.create!(email: 'joe@johnson.com', first_name: 'Joseph', last_name: 'Johnson', password: 'password', password_confirmation: 'password')
mary = User.create!(email: 'mary@lamb.com', first_name: 'Mary', last_name: 'Lamb', password: 'password', password_confirmation: 'password')

Task.create([{
                      title: "Some Task Here",
                      is_complete: true,
                      description: "This is a great task. Please make sure to read this great description!",
                      created_by: joe.id,
                      assigned_to: mary.id
                  },
                  {
                      title: "Another Task",
                      is_complete: false,
                      created_by: joe.id,
                      assigned_to: joe.id
                  },
                  {
                      title: "Super Duper Task",
                      is_complete: false,
                      created_by: joe.id,
                      assigned_to: mary.id
                  }])

Task.create([{
                      title: "Do the Dishes",
                      is_complete: false,
                      description: "Dang them dishes are dirty!",
                      created_by: mary.id,
                      assigned_to: joe.id
                  },
                  {
                      title: "45 minute yoga session",
                      is_complete: true,
                      created_by: joe.id,
                      assigned_to: mary.id
                  },
                  {
                      title: "Make TODO List",
                      is_complete: false,
                      created_by: joe.id,
                      assigned_to: joe.id
                  }])
