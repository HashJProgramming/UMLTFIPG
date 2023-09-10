from app import get_population_prediction, get_budget_prediction, get_population_prediction, generate_population_bar_plot, generate_budget_bar_plot, generate_bar_year

def test_get_budget_prediction():
    get_budget_prediction(2028, 2028)

def test_get_population_prediction():
    get_population_prediction(2028, 2028)

def test_generate_population_bar_plot():
    generate_population_bar_plot(2028, 2028)

def test_generate_budget_bar_plot():
    generate_budget_bar_plot(2028, 2028)
    
def test_generate_bar_year():
    generate_bar_year( 2028, 2028)
   
    
