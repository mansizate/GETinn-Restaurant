from flask import Flask, request, jsonify, render_template
from flask_cors import CORS
import pandas as pd
import joblib

app = Flask(__name__)
CORS(app)

# Load your trained model
pipeline = joblib.load("D:/mini project model/mini project/food_waste_pipeline.pkl")

@app.route('/')
def home():
    return render_template('index.html')

@app.route('/predict', methods=['POST'])
def predict():
    data = request.get_json()

    # Extract values from user input
    hs    = float(data['Household_Size'])
    meals = float(data['Number_of_Meals_Prepared'])
    shelf = float(data['Shelf_Life'])
    buy   = float(data['Purchase_Quantity_kg'])
    cons  = float(data['Consumed_Quantity_kg'])
    ft    = data['Food_Type']
    sm    = data['Storage_Method']
    rw    = data['Reason_for_Waste']

    # Feature engineering
    consumption_ratio = cons / buy if buy else 0
    leftover_flag     = 1 if (buy - cons) > 0 else 0
    hs_x_meals        = hs * meals
    waste_per_meal    = (buy - cons) / meals if meals else 0

    # Create dataframe
    df = pd.DataFrame([{
        'Household_Size': hs,
        'Number_of_Meals_Prepared': meals,
        'Shelf_Life': shelf,
        'Purchase_Quantity_kg': buy,
        'Consumed_Quantity_kg': cons,
        'Consumption_Ratio': consumption_ratio,
        'Leftover_Flag': leftover_flag,
        'Household_Size_x_Meals': hs_x_meals,
        'Waste_per_Meal': waste_per_meal,
        'Food_Type': ft,
        'Storage_Method': sm,
        'Reason_for_Waste': rw
    }])

    # Predict food waste in kg
    predicted_waste = pipeline.predict(df)[0]

    # Calculate waste and consumption percentages for pie chart
    waste = max(buy - cons, 0)
    total = cons + waste
    consumed_percent = round((cons / total) * 100, 2) if total else 0
    waste_percent = round((waste / total) * 100, 2) if total else 0

    return jsonify({
        'predicted_waste_kg': round(predicted_waste, 2),
        'pie_data': {
            'consumed_percent': consumed_percent,
            'waste_percent': waste_percent
        }
    })

if __name__ == '__main__':
    app.run(debug=True)
