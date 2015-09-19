class CreateFactorymasters < ActiveRecord::Migration
  def self.up
    create_table :factorymasters , :primary_key => :FactoryId do |t|
       t.column :FactoryName, :string, :null => false
    end
  end

  def self.down
    drop_table :factorymasters
  end
end