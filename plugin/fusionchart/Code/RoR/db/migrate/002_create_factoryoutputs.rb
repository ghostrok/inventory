class CreateFactoryoutputs < ActiveRecord::Migration
  def self.up
    create_table :factoryoutputs do |t|
       t.column :FactoryId, :integer, :null => false
       t.column :DatePro, :date, :null => false
       t.column :Quantity, :float,:null =>false
    end
  end

  execute "alter table factoryoutputs
add constraint fk_factoryoutputs_factorymasters
foreign key (FactoryId) references factorymasters(FactoryId)"


  def self.down
    drop_table :factoryoutputs
  end
end