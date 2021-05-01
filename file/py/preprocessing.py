import re
import os

import nltk
from nltk import sent_tokenize, word_tokenize

from nltk.cluster.util import cosine_distance
from nltk.corpus import stopwords
import string

from Sastrawi.Stemmer.StemmerFactory import StemmerFactory
from Sastrawi.StopWordRemover.StopWordRemoverFactory import StopWordRemoverFactory



#Stagging & Tokenizing
def stagging_text(text):
    text_str = sent_tokenize(text)
    pecahan = [word_tokenize(sent) for sent in text_str]
    return pecahan


#case folding
def text_lowercase(text): 
    return text.lower()

# Remove numbers 
def remove_numbers(text): 
    result = re.sub(r'\d+', '', text) 
    return result 

# remove whitespace from text 
def remove_whitespace(text): 
    return  " ".join(text.split()) 

# Filtering Process 
def remove_stopwords(text):   
    # Ambil data stopword
    module_dir = os.path.dirname(__file__)
    file_path = os.path.join(module_dir, 'stopword.txt')
    stopword_file = open(file_path, 'r')

    lots_of_stopwords = []
    
    print(stopword_file.read())
    for line in stopword_file.readlines():
        lots_of_stopwords.append(str(line.strip()))
    
    stop_words = set(lots_of_stopwords) 
    word_tokens = word_tokenize(text) 
    filtered_text = [word for word in word_tokens if word not in stop_words] 
    return filtered_text 

# Stemming
def steman(text):   
    factory = StemmerFactory()
    stemmer = factory.create_stemmer()
    kata = stemmer.stem(text)
    
    # katadasar = {}
    # kal = str(text)
    # for kata in kal:
    #     katadasar = stemmer.stem(kata)
    
    return kata

# Punctuation
# remove punctuation 
def remove_punctuation(text):
    plain = str(text)
    result = re.sub(r'\d+', '', plain) 
    translator = str.maketrans('', '', string.punctuation) 
    return result.translate(translator)



def stopword_plus(text):
    tokens = word_tokenize(text)
    listStopword =  set(stopwords.words('indonesian'))
    
    removed = []
    for t in tokens:
        if t not in listStopword:
            removed.append(t)
    
    return removed