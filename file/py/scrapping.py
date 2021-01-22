from bs4 import BeautifulSoup
import pandas as pd
import requests

import nltk
from newspaper import Article

def scrap_data(url: str) -> tuple:
    site = requests.get(url)
    soup = BeautifulSoup(site.text, 'html.parser')
    
    sentences = []
    
    text_element = soup.find_all('div', {'class' : 'content'})
    
    for sentence in text_element:
        sentences.append(sentence.text)

    return sentences

# Get Tittle
def get_title(url):
    gtitle = Article(url)
    gtitle.download()
    gtitle.parse()
    gtitle.title
    
    return gtitle.title