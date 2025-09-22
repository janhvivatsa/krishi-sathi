import tensorflow as tf
import os
from tensorflow.keras.callbacks import ModelCheckpoint

# --- Configuration ---
DATASET_PATH = 'dataset' # Path to the folder you created in Step 1
IMAGE_SIZE = (224, 224)
BATCH_SIZE = 32
EPOCHS = 10 # Number of times the model will see the entire dataset

# --- 1. Load the Data ---
print("Loading dataset...")
# Automatically load images and create a validation split (20%)
train_ds, val_ds = tf.keras.utils.image_dataset_from_directory(
    DATASET_PATH,
    validation_split=0.2,
    subset="both",
    seed=123,
    image_size=IMAGE_SIZE,
    batch_size=BATCH_SIZE
)
class_names = train_ds.class_names
print(f"Found classes: {class_names}")

# --- Configure dataset for performance ---
AUTOTUNE = tf.data.AUTOTUNE
train_ds = train_ds.shuffle(1000).prefetch(buffer_size=AUTOTUNE)
val_ds = val_ds.prefetch(buffer_size=AUTOTUNE)

# --- 2. Build the Model (Transfer Learning) ---
print("Building model...")
# Load MobileNetV2, a powerful pre-trained model, without its final layer
base_model = tf.keras.applications.MobileNetV2(
    input_shape=(224, 224, 3),
    include_top=False, # We don't want its original classifier
    weights='imagenet'
)
# Freeze the base model so we only train our new layers
base_model.trainable = False

# Create our new model on top
model = tf.keras.Sequential([
    # Add a layer to handle data augmentation/rescaling
    tf.keras.layers.Rescaling(1./255, input_shape=(224, 224, 3)),
    base_model,
    tf.keras.layers.GlobalAveragePooling2D(),
    tf.keras.layers.Dense(len(class_names)) # The output layer has one node for each disease
])

# --- 3. Compile the Model ---
print("Compiling model...")
model.compile(
    optimizer='adam',
    loss=tf.keras.losses.SparseCategoricalCrossentropy(from_logits=True),
    metrics=['accuracy']
)

model.summary()

# --- 4. Create Checkpoint and Train the Model ---
print("Creating checkpoint...")
checkpoint_cb = ModelCheckpoint(
    "plant_model_epoch_{epoch:02d}.h5", # Filepath for saving the model
    save_weights_only=False,
    save_best_only=False # Saves the model at the end of every epoch
)

print("Starting training...")
history = model.fit(
    train_ds,
    validation_data=val_ds,
    epochs=EPOCHS,
    callbacks=[checkpoint_cb] # <-- Pass the checkpoint in here
)
print("Training finished.")

# --- 5. Save the Final Model (Optional but Recommended) ---
# The checkpoint already saved the last epoch, but we can save it again
# with a cleaner name like 'final_model.h5'
print("Saving final model...")
model.save('final_plant_disease_model.h5')
print("Final model saved.")