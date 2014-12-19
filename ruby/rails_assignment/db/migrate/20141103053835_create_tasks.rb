class CreateTasks < ActiveRecord::Migration
  def change
    create_table :tasks do |t|
      t.string :title, null: false
      t.text :description, null: false, default: ""
      t.boolean :is_complete, null: false, default: false
      t.integer :created_by
      t.integer :assigned_to

      t.timestamps
    end
  end
end
