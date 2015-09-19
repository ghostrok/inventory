require File.dirname(__FILE__) + '/../test_helper'
require 'db_data_url_controller'

# Re-raise errors caught by the controller.
class DbDataUrlController; def rescue_action(e) raise e end; end

class DbDataUrlControllerTest < Test::Unit::TestCase
  def setup
    @controller = DbDataUrlController.new
    @request    = ActionController::TestRequest.new
    @response   = ActionController::TestResponse.new
  end

  # Replace this with your real tests.
  def test_truth
    assert true
  end
end
