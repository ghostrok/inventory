class Factorymaster < ActiveRecord::Base
    set_primary_key "FactoryId"
    has_many :factoryoutputs
end
